<?php


namespace core\models;


use common\models\DbPhones;
use common\models\DbRegion;
use common\models\helpers\PhoneRegionHelper;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use Yii;

/**
 * Class Form
 * @package core\models
 * @property string $URL
 * @property string $formType
 * @property string $pipeline
 * @property string $service
 * @property string $phone
 * @property string $gmt
 * @property string $name
 * @property string $email
 * @property string $comments
 * @property string $region
 * @property array $data
 * @property string $ip
 * @property string $utm_source
 * @property string $utm_campaign
 * @property string $section
 */

class Form
{
    public $data;

    public $URL;
    public $formType;
    public $pipeline;
    public $section;
    public $service;
    public $ip;

    public $name;
    public $phone;
    public $region;
    public $email;
    public $comments;
    public $gmt;
    public $utm_source;
    public $utm_campaign;

    public static $blockList = [
        '178.176.213.233',
        '2.92.127.207'
    ];

    const DESCRIPTION = [
        'name' => 'ФИО',
        'phone' => 'Телефон',
        'region' => 'Регион (телефон)',
        'email' => 'Почта',
        'comments' => 'Прочая информация',
        'URL' => 'URL',
        'formType' => 'Форма',
        'ip' => 'IP',
        'gmt' => 'Часовой пояс'
    ];

    const RU = [
        'name'
    ];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get__ip($ip) {
        $this->ip = $ip;
        return $this;
    }

    public function parse__region() {
        $this->phone = preg_replace("/[^0-9]/", '', (string)$this->phone);
        $dbReg = PhoneRegionHelper::getValidRegion($this->phone);
        if (!empty($dbReg)) {
            $parseMSK = explode('+', $dbReg->timezone);
            $newMSK = (int)$parseMSK[1] - 3;
            if ($newMSK >= 0)
                $textMSK = "+{$newMSK}";
            else
                $textMSK = "-{$newMSK}";
            $this->gmt = $textMSK;
            return $this->region = $dbReg->name_with_type;
        }
        return $this->region = null;
    }

    public function set__properties() {
        if (!empty($this->data)) {
            foreach ($this->data as $key => $item) {
                if (property_exists(self::class, $key) && $key !== 'data' && $key !== 'ip')  {
                    if ($key !== 'URL') {
                        if (!is_array($item))
                            $this->$key = $item;
                        else {
                            $this->$key = '';
                            foreach ($item as $buf)
                                $this->$key .= "{$buf}<br>";
                        }
                    }
                    else
                        $this->$key = "{$item}";
                }
            }
            return true;
        } else
            return false;
    }

    public function get__validators() {
        switch ($this->formType) {
            case 'Подписка на рассылку':
                return ['email', 'URL', 'formType', 'ip'];
            default:
                return ['name', 'phone', 'URL', 'formType', 'ip'];
        }
    }

    public function validate__properties() {
        $validators = $this->get__validators();
        foreach ($validators as $item) {
            if (empty($this->$item))
                return false;
            if ($this->formType !== 'Подписка на рассылку' && !preg_match('/[а-яА-Я\s]+/msi', $this->name))
                return false;
        }
        return true;
    }

    public function sign__email() {
        $id = '870468ad97ada8b6336ab6e1b96e33e3';
        $secret = '4af8c1a546ec639acb41c37febf9f1a0';
        $SPApiClient = new ApiClient($id, $secret, new FileStorage());
        $emails = array(
            array(
                'email' => $this->email,
                'variables' => array(
                    'phone' => $this->phone,
                    'имя' => $this->name,
                )
            )
        );
        $additionalParams = array(
            'confirmation' => 'force',
            'sender_email' => 'info@myforce.ru',
        );
        return $SPApiClient->addEmails(89247467, $emails, $additionalParams);
    }

    public function sent__to__bitrix() {
        $bitrix = new Bitrix();
        $sesVoronka = Yii::$app->session->get('voronka', 104);
        $input = [
            'phone' => $this->phone,
            'category' => $sesVoronka,//$this->pipeline,
            'gmt' => $this->gmt,
            'name' => $this->name,
            'formType' => $this->formType,
            'email' => $this->email,
            'utm_source' => $this->utm_source,
            'utm_campaign' => $this->utm_campaign,
            'comments' => $this->comments,
            'region' => $this->region,
            'URL' => $this->URL,
            'section' => $this->section,
        ];
        return $bitrix->start($input);
    }

    public function sent__email() {
        $html = "<div style='padding: 5px 15px'><p><b style='font-size: 20px;'>Новая заявка с сайта MyForce</b></p>";
        foreach (self::DESCRIPTION as $key => $item) {
            if (!empty($this->$key))
                $html .= "<p><b>{$item}:</b> {$this->$key}</p>";
        }
        $html .= "</div>";
        return Yii::$app->mailer
            ->compose()
            ->setFrom('info@myforce.ru')
            ->setTo('general@myforce.ru')
            ->setHtmlBody($html)
            ->setSubject('MyForce - заявка с сайта')
            ->send();
    }

    public function default__sent() {
        if (in_array($this->ip, static::$blockList))
            return ['status' => 'success'];
        $response['bitrix'] = $this->sent__to__bitrix();
        $response['email'] = $this->sent__email();
        return $response;
    }

    public function process__form() {
        switch ($this->formType) {
            case 'Подписка на рассылку':
                return $this->sign__email();
            default:
                return $this->default__sent();
        }
    }

}