<?php


namespace common\models;

use common\models\helpers\CustomIntegration;
use common\models\helpers\Mailer;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Yii;

/**
 * Class Worker
 * @package common\models
 * @property LeadsSentReport|null $alias
 * @property array $params
 * @property array $integrations
 * @property array $integrations__params
 * @property array $integrations__keys
 * @property array $integrations__associations
 * @property string $instance
 * @property string|null $status_description
 * @property Leads $lead
 * @property string $action
 * @property Clients|Orders $entity
 * @property UserModel $user
 * @property UsersBonuses $bonus
 * @property Clients $client
 */
class Worker
{

    const ACTION_SEND = 1;
    const ACTION_WASTE = 2;

    const INTEGRATION_BITRIX = 'bitrix';
    const INTEGRATION_AMO = 'amo';
    const INTEGRATION_WEBHOOK = 'webhook';
    const INTEGRATION_FAKE = 'fake';
    const INTEGRATION_TELEGRAM = 'telegram';

    const LOG_STATUS_NOTICE = 'notice';
    const LOG_STATUS_SUCCESS = 'success';
    const LOG_STATUS_ERROR = 'error';

    const INSTANCE_ORDER = 'order';
    const INSTANCE_CLIENT = 'client';

    const DEFAULT_CLOCK_INTERVAL = 334000;


    public $entity;
    public $lead;
    public $instance;
    public $params;
    public $alias;
    public $action;
    public $user;
    public $client;
    public $status_description;
    public $integrations;
    public $integrations__params;
    public $integrations__keys;
    public $integrations__associations;
    public $bonus;

    /**
     * Worker constructor.
     * @param Clients|Orders $entity
     * @param Leads $lead
     * @param int $action
     * @param string|null $status_description
     */
    public function __construct($entity, $lead, $action = self::ACTION_SEND, $status_description = null)
    {
        $this->entity = $entity;
        $this->lead = $lead;
        $this->action = $action; # send / waste / etc [constants]
        $this->status_description = $status_description;
        $this->get__params();
        $this->get__instance();
        $this->get__alias();
        $this->setup__default_order__params();
        $this->get__user();
    }

    public function setup__default_order__params() {
        if ($this->instance === self::INSTANCE_ORDER && !empty($this->entity->params_special)) {
            $p = $this->entity->params_special;
            if (!is_array($p))
                $p = json_decode($p, 1);
            if (!empty($p['exclude_commentary_params'])) {
                $params = $this->lead->params;
                foreach ($p['exclude_commentary_params'] as $item) {
                    $re = '/('.$item.'\:\s?\W*br>)/mi';
                    $this->lead->comments = preg_replace($re, '', $this->lead->comments);
                    if (!empty($params[$item]))
                        $params[$item] = null;
                }
                $this->lead->params = $params;
            }
        }
    }

    public function get__instance()
    {
        return $this->instance = $this->entity instanceof Clients ? self::INSTANCE_CLIENT : self::INSTANCE_ORDER;
    }

    public function get__emails()
    {
        $string = $this->instance === self::INSTANCE_CLIENT ? $this->entity->email : $this->entity->emails;
        if (empty($string) && $this->instance === self::INSTANCE_ORDER) {
            $this->client = Clients::findOne($this->entity->client);
            if (!empty($this->client) && !empty($this->client->email))
                $string = $this->client->email;
            else
                $string = '';
        }
        $arrayEmail = explode(' ', $string);
        return array_filter($arrayEmail, function ($element) {
            return !empty($element);
        });
    }

    public function get__params()
    {
        return $this->params = LeadsParams::find()
            ->where(['category' => $this->lead->type])
            ->asArray()
            ->all();
    }

    public function send__email()
    {
        $emails = $this->get__emails();
        if ($this->instance === self::INSTANCE_ORDER) {
            if (!empty($this->entity->params_special)) {
                $p = $this->entity->params_special;
                if (is_string($p))
                    $p = json_decode($p, 1);
                if (!empty($p['cancel_email_sending'])) {
                    $log['mail'] = 'Отправка почты заблокирована специальным параметром';
                    return !empty($log) && $this->set__log(json_encode($log), isset($log['exception']) ? self::LOG_STATUS_ERROR : self::LOG_STATUS_NOTICE);
                }
            }
        }
        if (!empty($emails)) {
            try {
                $log['mail'] = Yii::$app->mailer
                    ->compose(['html' => 'leads/send.php'], ['lead' => $this->lead, 'special__params' => $this->params, 'order_params' => $p ?? []])
                    ->setFrom('info@myforce.ru')
                    ->setTo($emails)
                    ->setSubject('Lead.Force - новый лид!')
                    ->send() ? 'Email was sent successfully' : 'There was an error while sending email.';
            } catch (\Exception $e) {
                $log['exception'] = $e;
            }
        }
        return !empty($log) && $this->set__log(json_encode($log), isset($log['exception']) ? self::LOG_STATUS_ERROR : self::LOG_STATUS_NOTICE);
    }

    public function sent__log()
    {
        if ($this->instance === self::INSTANCE_CLIENT) {
            $text = "Отправлен клиенту: #{$this->entity->id} {$this->entity->f} {$this->entity->i}";
        } else {
            $text = empty($this->entity->order_name) ?
                "Отправлен в заказ #{$this->entity->id} {$this->entity->category_text}" :
                "Отправлен в заказ #{$this->entity->id} {$this->entity->order_name}";
        }
        return ['date' => date('d.m.Y H:i:s'), 'text' => $text];
    }

    public function waste__log()
    {
        if ($this->instance === self::INSTANCE_CLIENT) {
            $text = "Отбраковка клиента: #{$this->entity->id} {$this->entity->f} {$this->entity->i}. Причина: {$this->status_description}";
        } else {
            $text = empty($this->entity->order_name) ?
                "Отправлен в брак в заказе #{$this->entity->id} {$this->entity->category_text}. Причина: {$this->status_description}" :
                "Отправлен в брак в заказе #{$this->entity->id} {$this->entity->order_name}. Причина: {$this->status_description}";
        }
        return ['date' => date('d.m.Y H:i:s'), 'text' => $text];
    }

    public function get__alias()
    {
        return $this->alias = LeadsSentReport::find()
                ->where([
                    'lead_id' => $this->lead->id,
                    'order_id' => $this->instance === self::INSTANCE_ORDER ? $this->entity->id : null,
                    'client_id' => $this->instance === self::INSTANCE_CLIENT ? $this->entity->id : $this->entity->client
                ])
                ->one() ?? null;
    }


    public function add__alias()
    {
        $this->alias = new LeadsSentReport();
        $this->alias->report_type = $this->instance;
        $this->alias->order_id = $this->instance === self::INSTANCE_ORDER ? $this->entity->id : null;
        $this->alias->client_id = $this->instance === self::INSTANCE_CLIENT ? $this->entity->id : $this->entity->client;
        $this->alias->lead_id = $this->lead->id;
        $this->alias->status = $this->get__status__type();
        $log = $this->get__log__type();
        $this->alias->log = json_encode([$log], JSON_UNESCAPED_UNICODE);
        $this->alias->status_commentary = $this->action === self::ACTION_SEND ? null : $this->status_description;
        /*$this->lead->system_data = array_merge(empty($this->lead->system_data) ? [] : $this->lead->system_data, [$log]);
        if (!is_array($this->lead->system_data))
            $this->lead->system_data = json_decode($this->lead->system_data, 1);*/
        $offer = OffersAlias::findOne(['lead_id' => $this->lead->id]);
        if (!empty($offer)) {
            $this->alias->offer_id = $offer->offer_id;
            $this->alias->provider_id = $offer->provider_id;
        }
        return $this->alias->save();
    }

    public function get__log__type()
    {
        switch ($this->action) {
            default:
            case self::ACTION_SEND:
                $log_type = $this->sent__log();
                break;
            case self::ACTION_WASTE:
                $log_type = $this->waste__log();
                break;
        }
        return $log_type;
    }

    public function get__status__type()
    {
        switch ($this->action) {
            default:
            case self::ACTION_SEND:
                $status_type = 'отправлен';
                break;
            case self::ACTION_WASTE:
                $status_type = 'брак';
                break;
        }
        return $status_type;
    }

    public function update__alias()
    {
        # note that leads model have auto-update behavior on status and log properties
        $log = json_decode($this->alias->log, JSON_UNESCAPED_UNICODE);
        $log[] = $this->get__log__type();
        $this->alias->status = $this->get__status__type();
        $this->alias->log = json_encode($log, JSON_UNESCAPED_UNICODE);
        $this->alias->status_commentary = $this->action === self::ACTION_SEND ? null : $this->status_description;
        $offer = OffersAlias::findOne(['lead_id' => $this->lead->id]);
        if (!empty($offer)) {
            $this->alias->offer_id = $offer->offer_id;
            $this->alias->provider_id = $offer->provider_id;
        }
        return $this->alias->update() !== false;
    }

    public function get__integrations()
    {
        $client = $this->instance === self::INSTANCE_CLIENT ? $this->entity->id : $this->entity->client;
        $this->integrations = Integrations::find()
            ->where(['entity' => $this->instance, 'entity_id' => $this->entity->id])
            ->asArray()
            ->all();
        if ($this->instance === self::INSTANCE_ORDER && empty($this->integrations)) { # if not exist order-specified integrations
            $this->integrations = Integrations::find()
                ->where(['entity' => self::INSTANCE_CLIENT, 'entity_id' => $client])
                ->asArray()
                ->all();
        }
        if ($this->get__instance() === self::INSTANCE_ORDER) {
            $rsp['custom'] = CustomIntegration::use__integration($this->entity->id, $this->lead);
            if(!empty($rsp['custom']))
                $this->set__log($rsp['custom'], self::LOG_STATUS_NOTICE);
        }
        return !empty($this->integrations);
    }

    private function get__config($json)
    {
        return json_decode($json, true);
    }

    public function order__specific__bitrix__fix($comments) {
        if ($this->entity instanceof Orders) {
            switch ($this->entity->id) {
                case 217:
                    $comments = "Перед кем у вас задолженность?: Другие / <br> Когда вносили последний платеж?: 1-2 месяца назад <br>Каким имуществом вы владеете?: Единственное жилье (квартира, дом, дача) / <br> Как вам сообщить расчет?: Позвоните мне по телефону";
                    break;
                case 219:
                    $comments = "ФИО: {$this->lead->name} <br> Телефон: {$this->lead->phone}";
                    if (!empty($this->lead->params['sum']))
                        $comments .= "<br>Сумма долга: {$this->lead->params['sum']}";
                    break;
            }
        }
        return $comments;
    }

    public function integration__bitrix($integration)
    {
        $config = $this->get__config($integration['config']);
        $url = $config['WEBHOOK_URL'];
        unset($config['WEBHOOK_URL']);
        $fields = [
            "TITLE" => "Заявка от " . $this->lead->name,
            "NAME" => $this->lead->name,
            "STATUS_ID" => "NEW",
            "OPENED" => "Y",
            "ASSIGNED_BY_ID" => 1,
            "SOURCE_ID" => "WEB",
            "SOURCE_DESCRIPTION" => 'Лид от Lead.Force',
            "PHONE" => [["VALUE" => $this->lead->phone, "VALUE_TYPE" => "WORK"]],
            "EMAIL" => [["VALUE" => $this->lead->email, "VALUE_TYPE" => "WORK"]],
            "COMMENTS" => ''
        ];
        $fields['COMMENTS'] .= !empty($this->lead->region) ? "Регион: {$this->lead->region} <br>" : '';
        $fields['COMMENTS'] .= !empty($this->lead->city) ? "Город: {$this->lead->city} <br>" : '';
        $fields['COMMENTS'] .= !empty($this->lead->comments) ? "Прочая информация: {$this->lead->comments} <br>" : '';
        foreach ($this->params as $param) {
            $fields['COMMENTS'] .= !empty($this->lead->params[$param['name']]) ? "{$param['description']}: {$this->lead->params[$param['name']]} <br>" : '';
        }
        if ($this->instance === self::INSTANCE_ORDER) {
            if (!empty($this->entity->params_special)) {
                $p = $this->entity->params_special;
                if (is_string($p))
                    $p = json_decode($p, 1);
                if (!empty($p['delete_comment']))
                    $fields['COMMENTS'] = '';
            }
        }
        $config = $this->associate__bitrix($config);
        $fields = array_merge($fields, $config);
        $fields['COMMENTS'] = $this->order__specific__bitrix__fix($fields['COMMENTS']);
        $data = [
            'fields' => $fields,
            'params' => ['REGISTER_SONET_EVENT' => 'Y']
        ];
        $response = self::use__bitrix__api("{$url}/crm.lead.add", $data);
        $arrayResponse = json_decode($response, true);
        return $this->set__log($response, isset($arrayResponse['error']) ? self::LOG_STATUS_ERROR : self::LOG_STATUS_SUCCESS);
    }

    public function set__log($data, $status = 'notice')
    {
        $log = new LogProcessor();
        $log->data = $data;
        $log->status = $status;
        $log->lead_id = $this->lead->id;
        $log->entity = $this->instance === self::INSTANCE_CLIENT ? "client_{$this->entity->id}" : "order_{$this->entity->id}";
        return $log->save();
    }

    public function integration__amo($integration)
    {
        $config = $this->get__config($integration['config']);
        $customFields = [];
        $default = ['pipeline_id', 'status_id', 'responsible_user_id'];
        $not_support = [
            'legal_entity',
            'date_time',
            'birthday',
            'streetaddress',
            'smart_address',
            'date',
            'url',
        ];
        foreach ($config['fields'] as $typeC => $c) {
            foreach ($c as $key => $item) {
                if (in_array($key, $default))
                    continue;
                if ($item['type'] === 'multitext') {
                    $customFields[$typeC][] = [
                        'field_id' => $key,
                        'values' => [
                            [
                                'value' => $this->associate__elem($item['value']),
                                'enum_id' => (int)$item['enum_id'],
                            ]
                        ],
                    ];
                } elseif ($item['type'] === 'multiselect') {
                    $exploded = explode(',', $item['value']);
                    $values = [];
                    foreach ($exploded as $e) {
                        $values[] = [
                            'enum_id' => (int)$e,
                        ];
                    }
                    $customFields[$typeC][] = [
                        'field_id' => $key,
                        'values' => $values,
                    ];
                } elseif ($item['type'] === 'select' || $item['type'] === 'radiobutton') {
                    $customFields[$typeC][] = [
                        'field_id' => $key,
                        'values' => [
                            [
                                'enum_id' => (int)$item['value'],
                            ]
                        ],
                    ];
                } else {
                    if(!in_array($item['type'], $not_support)) {
                        if ($item['type'] === 'checkbox')
                            $val = true;
                        elseif ($item['type'] === 'int' || $item['type'] === 'numeric')
                            $val = (int)$this->associate__elem($item['value']);
                        else
                            $val = $this->associate__elem($item['value']);
                        $customFields[$typeC][] = [
                            'field_id' => $key,
                            'values' => [
                                [
                                    'value' => $val,
                                ]
                            ],
                        ];
                    }
                }
            }
        }
        $formatted = [
            [
                "name" => $this->lead->name,
                "_embedded" => [
                    /*'tags' => [
                        [
                            [
                                //"id" => 100667,
                                "name" => "MYFORCE",
                                "color" => null,
                            ]
                        ]
                    ],*/
                    "contacts" => [
                        [
                            "first_name" => $this->lead->name,
                            "custom_fields_values" => !empty($customFields['contacts']) ? $customFields['contacts'] : []
                        ]
                    ],
                ],
                "status_id" => !empty($config['fields']['leads']['status_id']['value']) ? (int)$config['fields']['leads']['status_id']['value'] : null,
                "pipeline_id" => !empty($config['fields']['leads']['pipeline_id']['value']) ? (int)$config['fields']['leads']['pipeline_id']['value'] : null,
                "responsible_user_id" => !empty($config['fields']['leads']['responsible_user_id']['value']) ? (int)$config['fields']['leads']['responsible_user_id']['value'] : null,
                "custom_fields_values" => $customFields['leads']
            ]
        ];
        $rsp = self::use__amo__api($config['config']['server'], $config['config']['access_token'], $formatted);
        $rspArray = json_decode($rsp, true);
        return $this->set__log($rsp, isset($rspArray[0]['id']) ? self::LOG_STATUS_SUCCESS : self::LOG_STATUS_ERROR);
    }

    public function integration__webhook($integration)
    {
        $config = $this->get__config($integration['config']);
        $leadArray = [
            'id' => $this->lead->id,
            'name' => $this->lead->name,
            'email' => $this->lead->email,
            'phone' => $this->lead->phone,
            'region' => $this->lead->region,
            'city' => $this->lead->city,
            'comments' => $this->lead->comments,
            'params' => $this->lead->params,
            'date' => date("d.m.Y H:i"),
            'integration_type' => $this->instance === self::INSTANCE_ORDER ? "Заказ #{$this->entity->id}" : "Общая интеграция",
            'tag' => 'myforce'
        ];
        $data_string = json_encode($leadArray, JSON_UNESCAPED_UNICODE);
        $curl = curl_init($config['WEBHOOK_URL']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result) !== null ?
            $this->set__log($result, self::LOG_STATUS_NOTICE) :
            $this->set__log(json_encode(['error' => 'Webhook response data format is not JSON'], JSON_UNESCAPED_UNICODE), self::LOG_STATUS_ERROR);
    }

    public function integration__fake($integration) {
        $config = $this->get__config($integration['config']);
        $to = $config['email_fake'];
        $subject = 'LeadGen новый лид!';
        $message = '<html>';
        $message .= '<head><style>.im{color:#000001 !important;}</style></head>';
        $message .= '<body>';
        $message .= '<div>';
        $message .= "<p><b>Поступление нового лида от LeadGen</b></p>";
        $message .= '<table style="border: 1px solid transparent; font-size: 18px;" cellspacing="1" cellpadding="3">';
        $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
        $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Поступил</th>';
        $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. date('d.m.y H:i') .'</td>';
        $message .= '</tr>';
        if (!empty($this->lead->name)) {
            $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
            $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">ФИО</th>';
            $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->name .'</td>';
            $message .= '</tr>';
        }
        $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
        $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Телефон</th>';
        $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->phone .'</td>';
        $message .= '</tr>';
        if(!empty($this->lead->email)) {
            $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
            $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Email</th>';
            $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->email .'</td>';
            $message .= '</tr>';
        }
        if (!empty($this->lead->params['sum']) && $this->lead->type === 'dolgi') {
            $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
            $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Сумма</th>';
            $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->params['sum'] .'</td>';
            $message .= '</tr>';
        }
        if (!empty($this->lead->params['chargeback_sum']) && $this->lead->type === 'chardjbek') {
            $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
            $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Сумма возврата</th>';
            $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->params['chargeback_sum'] .'</td>';
            $message .= '</tr>';
        }
        if (!empty($this->lead->region)) {
            $message .= '<tr style="padding-top: 2px; height: 32px !important;">';
            $message .= '<th style="background-color: #303030; color: whitesmoke; text-align: left; padding: 10px 15px">Регион</th>';
            $message .= '<td style="padding-left: 10px; border: 1px solid #dcdcdc; min-width: 300px;">'. $this->lead->region .'</td>';
        }
        $message .= '</tr>';
        $message .= '</table>';
        $message .= '</div>';
        $message .= '</body>';
        $message .= '</html>';
        $headers = 'From: ' . "leads@leadgen.org" . PHP_EOL;
        $headers .= 'Reply-To: ' . "leads@leadgen.org" . PHP_EOL;
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $rsp = mail($to, $subject, $message, $headers);
        $this->set__log(json_encode(['fake_mail' => $rsp]), $rsp ? self::LOG_STATUS_NOTICE : self::LOG_STATUS_ERROR);
        return $rsp;
    }

    public static function telegram__sent__message($peer, $text, $token) {
        usleep(125000);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/{$token}/sendMessage");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $peer,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        return $result2;
    }

    public function integration__telegram($integration) {
        $config = self::get__config($integration['config']);
        $telegaText = "<b>Поступил новый лид " . date("d.m.Y H:i") . "</b>\n\n";
        $telegaText .= !empty($this->lead->name) ? "ФИО: {$this->lead->name}\n" : "";
        $telegaText .= !empty($this->lead->phone) ? "Телефон: {$this->lead->phone}\n" : "";
        $telegaText .= !empty($this->lead->email) ? "Email: {$this->lead->email}\n" : "";
        $telegaText .= !empty($this->lead->region) ? "Регион: {$this->lead->region}\n" : "";
        if (!empty($config['comments']) && $config['comments'] === 'да')
            $telegaText .= !empty($this->lead->comments) ? "Комментарии: \n" . preg_replace('#<br\s*/?>#i', "\n", strip_tags($this->lead->comments, "<br>")) : "";
        if ($this->lead->type === 'dolgi')
            $telegaText .= !empty($this->lead->params['sum']) ? "Сумма: {$this->lead->params['sum']} руб.\n" : "";
        elseif($this->lead->type === 'chardjbek')
            $telegaText .= !empty($this->lead->params['chargeback_sum']) ? "Сумма возврата: {$this->lead->params['chargeback_sum']} руб.\n" : "";
        $rsp = self::telegram__sent__message($config['peer'], $telegaText, $config['id']);
        $this->set__log($rsp, self::LOG_STATUS_NOTICE);
        return $rsp;
    }

    public function associate__bitrix($config)
    {
        foreach ($config as $key => $c)
            $config[$key] = $this->associate__elem($c);
        return $config;
    }

    public function associate__elem($value)
    {
        foreach ($this->integrations__keys as $key) {
            if (strpos($key, "LEAD_PARAM_") !== false) {
                if (!empty($this->lead->params[$this->integrations__associations[$key]]))
                    $value = str_replace($key, $this->lead->params[$this->integrations__associations[$key]], $value);
            }
            else {
                if (!empty($this->lead->{$this->integrations__associations[$key]}))
                    $value = str_replace($key, $this->lead->{$this->integrations__associations[$key]}, $value);
            }
        }
        return $value;
    }

    public function set__keys__associations()
    {
        foreach ($this->integrations__params as $param) {
            $this->integrations__keys[] = $param['name'];
            $this->integrations__associations[$param['name']] = $param['assigned_param'];
        }
        foreach ($this->params as $item) {
            $this->integrations__keys[] = "LEAD_PARAM_{$item['name']}";
            $this->integrations__associations["LEAD_PARAM_{$item['name']}"] = $item['name'];
        }
    }

    public function use__integrations()
    {
        $rsp = [];
        $this->integrations__params = IntegrationsSpecialParams::find()->asArray()->all();
        $this->set__keys__associations();
        foreach ($this->integrations as $integration) {
            switch ($integration['integration_type']) {
                case self::INTEGRATION_BITRIX:
                    $rsp['bitrix'] = $this->integration__bitrix($integration);
                    break;
                case self::INTEGRATION_AMO:
                    $rsp['amo'] = $this->integration__amo($integration);
                    break;
                case self::INTEGRATION_WEBHOOK:
                    $rsp['webhook'] = $this->integration__webhook($integration);
                    break;
                case self::INTEGRATION_FAKE:
                    $rsp['fake'] = $this->integration__fake($integration);
                    break;
                case self::INTEGRATION_TELEGRAM:
                    $rsp['telegram'] = $this->integration__telegram($integration);
                    break;
                default:
                    $rsp['error'] = $this->set__log(json_encode(['error' => 'Unknown integration type'], JSON_UNESCAPED_UNICODE), self::LOG_STATUS_ERROR);
                    break;
            }
        }
        return $rsp;
    }

    public static function use__bitrix__api($url, $data)
    {
        usleep(self::DEFAULT_CLOCK_INTERVAL);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => true,
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $url,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => http_build_query($data)
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public static function use__amo__api($server, $token, $add)
    {
        usleep(self::DEFAULT_CLOCK_INTERVAL);
        $subdomain = $server;
        $link = 'https://' . $subdomain . '/api/v4/leads/complex';
        $access_token = $token;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token,
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($add));
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    public function get__user() {
        if ($this->instance === 'client')
            $this->user = empty($this->entity->user_id) ? null : UserModel::findOne($this->entity->user_id);
        else {
            if (empty($this->client)) {
                $this->client = Clients::findOne($this->entity->client);
            }
            $this->user = empty($this->client->user_id) ? null : UserModel::findOne($this->client->user_id);
        }
        if (!empty($this->user)) {
            $this->bonus = UsersBonuses::findOne(['user_id' => $this->user->id]);
        }
        return $this->user;
    }

    public function actualize__budget() {
        $budgetLog = new BudgetLog();
        $budgetLog->user_id = $this->user->id;
        $budgetLog->budget_was = $this->user->budget;
        if ($this->instance === 'client') {
            $this->user->budget = $this->user->budget - $this->lead->auction_price;
            $budgetLog->text = "Покупа лида #{$this->lead->id}, Аукцион: -{$this->lead->auction_price} руб.";
        } else {
            $bonus__sale = !empty($this->bonus) && !empty($this->bonus->additional_sale) ? $this->bonus->additional_sale : 0;
            if (empty($this->entity->sale)) {
                $this->user->budget = $this->user->budget - round($this->entity->price * (1 - $bonus__sale*0.01), 2);
                $budgetLog->text = "Лид #{$this->lead->id} в заказе #{$this->entity->id}: -" . round($this->entity->price * (1 - $bonus__sale*0.01)) . " руб.";
            } else {
                $this->user->budget = $this->user->budget - round($this->entity->price * (1 - ($this->entity->sale + $bonus__sale)*0.01), 2);
                $budgetLog->text = "Лид #{$this->lead->id} в заказе #{$this->entity->id}: -" . round($this->entity->price * (1 - ($this->entity->sale + $bonus__sale)*0.01)) . " руб.";
            }
        }
        $budgetLog->budget_after = $this->user->budget;
        /*if ($this->user->budget <= 2000 && $this->user->budget > 1000 && !empty($this->user->email)) {
            $jq = JobsQueue::find()
                ->where(['user_id' => $this->user->id, 'method' => 'execute__mailer'])
                ->andWhere(['like', 'params', "%9_balance%", false])
                ->andWhere(['status' => 'wait'])
                ->andWhere(['>=', 'date_start', date("Y-m-d H:i:s")])
                ->count();
            if ($jq === 0) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $this->user->email, 'html' => '9_balance', 'title' => Mailer::TITLES['9_balance']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = date("Y-m-d H:i:s", time() + 3600 * 5);
                $queue->status = 'wait';
                $queue->user_id = $this->user->id;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
        if ($this->user->budget <= 0 && !empty($this->user->email)) {
            $jq = JobsQueue::find()
                ->where(['user_id' => $this->user->id, 'method' => 'execute__mailer'])
                ->andWhere(['like', 'params', "%10_balance%", false])
                ->andWhere(['status' => 'wait'])
                ->andWhere(['>=', 'date_start', date("Y-m-d H:i:s")])
                ->count();
            if ($jq === 0) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $this->user->email, 'html' => '10_balance', 'title' => Mailer::TITLES['10_balance']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = date("Y-m-d H:i:s", time() + 3600 * 5);
                $queue->status = 'wait';
                $queue->user_id = $this->user->id;
                $queue->closed = 0;
                $queue->save();
            }
        }
        return $this->user->update() && $budgetLog->save();
    }

    public function actualize__order() {
        $this->entity->leads_get++;
        $this->entity->last_lead_get = time();
        /*if (!empty($this->user->email))
            $this->percentage__mailer__order();*/
        if ($this->entity->leads_get >= $this->entity->leads_count)  {
            $this->entity->status = Orders::STATUS_FINISHED;
            $this->entity->date_end = date("Y-m-d H:i:s");
            /*if (!empty($this->user->email)) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $this->user->email, 'html' => '4_orders', 'title' => Mailer::TITLES['4_orders']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = date("Y-m-d H:i:s");
                $queue->status = 'wait';
                $queue->user_id = $this->user->id;
                $queue->closed = 0;
                $queue->save();
            }*/
            $queue = new JobsQueue();
            $queue->method = "tg__worker00";
            $tgMsg = "По <a href='https://admin.myforce.ru/lead-force/orders/update?id={$this->entity->id}'>заказу \"{$this->entity->order_name}\"</a> выгружено 100% заказа, необходимо закрыть клиента на новый пакет.";
            $queue->params = json_encode(['message' => $tgMsg], JSON_UNESCAPED_UNICODE);
            $queue->date_start = date("Y-m-d H:i:s");
            $queue->status = 'wait';
            $queue->user_id = $this->user->id;
            $queue->closed = 0;
            $queue->save();
            $otherOrders = Orders::find()
                ->where(['client' => $this->entity->client])
                ->andWhere(['!=', 'status', Orders::STATUS_FINISHED])
                ->count();
            $usr = UserModel::findOne([$this->client->user_id]);
            if ($otherOrders === 0 && !empty($usr) && $usr->budget > 0) {
                $queue = new JobsQueue();
                $queue->method = "tg__worker00";
                $tgMsg = "У <a href='https://admin.myforce.ru/lead-force/clients?ClientsSearch%5Bid%5D={$this->entity->client}&ClientsSearch%5Bclient_name%5D=&ClientsSearch%5Bemail%5D=&ClientsSearch%5Bcommentary%5D='>клиента #{$this->entity->client}</a> остался свободный баланс ЛК без действующих заказов. Надо срочно это исправить " . hex2bin('F09F9883');
                $queue->params = json_encode(['message' => $tgMsg], JSON_UNESCAPED_UNICODE);
                $queue->date_start = date("Y-m-d H:i:s");
                $queue->status = 'wait';
                $queue->user_id = $this->user->id;
                $queue->closed = 0;
                $queue->save();
            }
        }
        return $this->entity->update();
    }

    public function percentage__mailer__order() {
        $percent = round(100 * ($this->entity->leads_get / $this->entity->leads_count), 2);
        $cfg = json_decode($this->entity->mailer_config, 1);
        if (!empty($cfg)) {
            if (isset($cfg['8_orders_match']) && $cfg['8_orders_match'] == 0) {
                if ($percent >= 10) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '8_orders_match', 'title' => Mailer::TITLES['8_orders_match']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['8_orders_match'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if (isset($cfg['7_orders_match']) && $cfg['7_orders_match'] == 0) {
                if ($percent >= 25) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '7_orders_match', 'title' => Mailer::TITLES['7_orders_match']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['7_orders_match'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if (isset($cfg['18_orders']) && $cfg['18_orders'] == 0) {
                if ($percent >= 35) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '18_orders', 'title' => Mailer::TITLES['18_orders']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['18_orders'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if (isset($cfg['6_orders_match']) && $cfg['6_orders_match'] == 0) {
                if ($percent >= 50) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '6_orders_match', 'title' => Mailer::TITLES['6_orders_match']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['6_orders_match'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if (isset($cfg['5_orders_match']) && $cfg['5_orders_match'] == 0) {
                if ($percent >= 80) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '5_orders_match', 'title' => Mailer::TITLES['5_orders_match']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '5_orders_match', 'title' => Mailer::TITLES['5_orders_match']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s", time() + 3600 * 8);
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $queue = new JobsQueue();
                    $queue->method = "tg__worker00";
                    $tgMsg = "По <a href='https://admin.myforce.ru/lead-force/orders/update?id={$this->entity->id}'>заказу \"{$this->entity->order_name}\"</a> выгружено 80% заказа, необходимо предложить пролонгацию со скидкой.";
                    $queue->params = json_encode(['message' => $tgMsg], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['5_orders_match'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if (isset($cfg['18_orders']) && $cfg['18_orders'] == 1) {
                if ($percent >= 90) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '18_orders', 'title' => Mailer::TITLES['18_orders']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['18_orders'] = 2;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                }
            }
            if ($this->entity->leads_get >= 5) {
                if (isset($cfg['11_orders']) && $cfg['11_orders'] == 0) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '11_orders', 'title' => Mailer::TITLES['11_orders']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['11_orders'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                    $jq = JobsQueue::find()
                        ->where(['user_id' => $this->user->id, 'method' => 'execute__mailer'])
                        ->andWhere(['like', 'params', "%11_orders%", false])
                        ->andWhere(['>=', 'date_start', date("Y-m-d H:i:s", time() + 24 * 3600)])
                        ->andWhere(['status' => 'wait'])
                        ->count();
                    if ($jq === 0)
                        Mailer::create__orders__queue__11($this->user->email, $this->user->id);
                }
            }
            if ($this->entity->leads_get === 1) {
                if (isset($cfg['14_orders']) && $cfg['14_orders'] == 0) {
                    $queue = new JobsQueue();
                    $queue->method = "execute__mailer";
                    $queue->params = json_encode(["to" => $this->user->email, 'html' => '14_orders', 'title' => Mailer::TITLES['14_orders']], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $this->user->id;
                    $queue->closed = 0;
                    $queue->save();
                    $cfg['14_orders'] = 1;
                    $this->entity->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                    $this->entity->update();
                    $jq = JobsQueue::find()
                        ->where(['user_id' => $this->user->id, 'method' => 'execute__mailer'])
                        ->andWhere(['like', 'params', "%14_orders%", false])
                        ->andWhere(['>=', 'date_start', date("Y-m-d H:i:s", time() + 24 * 3600)])
                        ->andWhere(['status' => 'wait'])
                        ->count();
                    if ($jq === 0)
                        Mailer::create__orders__queue_14($this->user->email, $this->user->id);
                }
            }
        }
    }


    public function create__notice() {
        $notice = new UsersNotice();
        $notice->user_id = $this->user->id;
        $notice->type = $notice::TYPE_NEW_LEAD;
        $notice->active = 1;
        if ($this->instance === self::INSTANCE_ORDER) {
            $notice->text = "Поступил новый лид в заказе №{$this->entity->id} {$this->entity->category_text}. Проверьте подробности заказа";
            $notice->properties = json_encode(['lead_id' => $this->lead->id, 'order_id' => $this->entity->id], JSON_UNESCAPED_UNICODE);
        }
        else {
            $notice->properties = json_encode(['lead_id' => $this->lead->id], JSON_UNESCAPED_UNICODE);
            $notice->text = "Новый лид успешно куплен на аукционе. Проверьте вкладку лидов";
        }
        return $notice->save();
    }

    public function processing__new() {
        $this->get__alias();
        if (empty($this->alias)) {
            $changeBudget = true;
            $alias = $this->add__alias();
            if ($this->instance === self::INSTANCE_ORDER)
                $this->actualize__order();
        } else {
            $changeBudget = false;
            $alias = $this->update__alias();
        }
        if ($alias) {
            if (!empty($this->user) && $changeBudget) {
                $this->actualize__budget();
                $properties = UsersProperties::findOne(['user_id' => $this->user->id]);
                $params = json_decode($properties->params, 1);
                if ($params !== null && $params['profile']['new_lead'] == 1)
                    $this->create__notice();
            }
            $response['email'] = $this->send__email();
            if (!empty($this->get__integrations())) {
                $response['integrations'] = $this->use__integrations();
            }
        } else {
            $response['alias_error'] = $this->set__log(['error' => 'Alias creation or update error.', self::LOG_STATUS_ERROR]);
        }
        return $response;
    }


    public function processing__waste() {
        $this->get__alias();
        if (empty($this->alias))
            $response['alias_error'] = $this->set__log(['error' => 'Can\'t find alias model to mark as waste.', self::LOG_STATUS_ERROR]);
        else {
            $alias = $this->update__alias();
            if ($alias) {
                $response['alias'] = $alias;
            } else {
                $response['alias_error'] = $this->set__log(['error' => 'Alias update error.', self::LOG_STATUS_ERROR]);
            }
        }
        return $response;
    }



}