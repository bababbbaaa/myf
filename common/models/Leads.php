<?php

namespace common\models;

use common\behaviors\JsonBehavior;
use Yii;

/**
 * This is the model class for table "leads".
 *
 * @property int $id ID
 * @property string $source
 * @property string|null $utm_source
 * @property string|null $utm_campaign
 * @property string|null $utm_medium
 * @property string|null $utm_content
 * @property string|null $utm_term
 * @property string|null $utm_title
 * @property string|null $utm_device_type
 * @property string|null $utm_age
 * @property string|null $utm_inst
 * @property string|null $utm_special
 * @property string $ip IP
 * @property string $date_income Дата поступления
 * @property string $date_change Дата изменения
 * @property string $status Статус лида
 * @property string|null $system_data Системные параметры
 * @property string $type Тип лида
 * @property string|null $name Имя
 * @property string|null $email Email
 * @property string $phone Телефон
 * @property string|null $region Регион
 * @property string|null $city Город
 * @property string|null $comments Комментарии
 * @property string|null $params Параметры лида
 * @property float $auction_price Цена аукциона
 * @property int $cc_check Проверен КЦ
 * @property int $sms_check Проверен по SMS
 * @property int $autocall_check Пришел с прозвона
 *
 * @property LeadsParamsValues[] $leadsParamsValues
 * @property LeadsSentReport[] $leadsSentReports
 */
class Leads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const STATUS_NEW = 'новый';
    const STATUS_SENT = 'отправлен';
    const STATUS_MODERATE = 'не отправлен';
    const STATUS_WASTE = 'брак';
    const STATUS_CONFIRMED = 'подтвержден';
    const STATUS_INTERVAL = 'интервал';
    const STATUS_AUCTION = 'аукцион';


    public function behaviors()
    {
        return [
            'systemDataBehavior' => [
                'class' => JsonBehavior::class,
                'property' => 'system_data',
                'jsonField' => 'system_data',
            ],
            'paramsBehavior' => [
                'class' => JsonBehavior::class,
                'property' => 'params',
                'jsonField' => 'params',
            ]
        ];
    }

    /**
     * @param $model CcLeads
     * @return Leads
     */
    public function generateFromCC($model) {
        $this->source = empty($model->special_source) ? 'Контакт-центр' : $model->special_source;
        $this->utm_source = $model->utm_source;
        $this->utm_campaign = $model->utm_campaign;
        $this->ip = "127.0.0.1";
        $this->status = "новый";
        $this->type = $model->category;
        $this->name = $model->name;
        $this->phone = $model->phone;
        $this->region = $model->region;
        $this->city = $model->city;
        $this->cc_check = 1;
        $this->comments = '';
        if (!empty($model->params)) {
            $params = json_decode($model->params, true);
            if (!empty($params)) {
                foreach ($params as $key => $item) {
                    $this->comments .= "{$key}: {$item}<br>";
                }
            }
            $leadParams = LeadsParams::find()->where(['category' => $this->type])->asArray()->all();
            if (!empty($leadParams)) {
                foreach ($leadParams as $item) {
                    if (isset($params[$item['name']])) {
                        $saveParams[$item['name']] = $item['type'] === 'number' ? (int)$params[$item['name']] : (string) $params[$item['name']];
                    }
                }
            }
            if (!empty($saveParams))
                $this->params = $saveParams;
        } else
            $this->params = null;
        $this->system_data = null;
        return $this;
    }

    public static function tableName()
    {
        return 'leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $params = self::categoryParams();
        $string = [];
        $numeric = [];
        $required = [];
        if (!empty($params)) {
            foreach ($params as $item) {
                if ($item->type === 'string')
                    $string[] = $item->name;
                else
                    $numeric[] = $item->name;
                if($item->required === 1)
                    $required[] = $item->name;
            }
        }
        $dRequired = ['ip', 'type', 'phone', 'source'];
        #$dRequired = array_merge($dRequired, $required);
        $dNumeric = ['cc_check', 'sms_check', 'autocall_check'];
        #$dNumeric = array_merge($dNumeric, $numeric);
        $dString = ['system_data', 'comments', 'params'];
        #$dString = array_merge($dString, $string);
        return [
            [$dRequired, 'required'],
            [['date_income', 'date_change'], 'safe'],
            [['auction_price'], 'number'],
            [$dNumeric, 'integer'],
            [$dString, 'string'],
            [['ip', 'status', 'type', 'name', 'email', 'phone', 'region', 'city', 'source', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_term', 'utm_title', 'utm_device_type', 'utm_age', 'utm_inst', 'utm_special',], 'string', 'max' => 255],
        ];
    }

    public function categoryParams() {
        return !empty($this->type) ? LeadsParams::find()->where(['category' => $this->type])->all() : null;
    }

    /**
     * {@inheritdoc}
     */

    public function attributes()
    {
        $parent = parent::attributes();
        /*$params = self::categoryParams();
        if (!empty($params)) {
            foreach ($params as $item)
                $parent[] = $item->name;
        }*/
        return $parent;
    }

    public function attributeLabels()
    {
        $labels = [];
        /*$params = self::categoryParams();
        if (!empty($params)) {
            foreach ($params as $item) {
                $labels[$item->name] = $item->description;
            }
        }*/
        $def = [
            'id' => 'ID',
            'source' => 'Источник',
            'utm_source' => 'utm_source',
            'utm_campaign' => 'utm_campaign',
            'utm_medium' => 'utm_medium',
            'utm_content' => 'utm_content',
            'utm_term' => 'utm_term',
            'utm_title' => 'utm_title',
            'utm_device_type' => 'utm_device_type',
            'utm_age' => 'utm_age',
            'utm_inst' => 'utm_inst',
            'utm_special' => 'utm_special',
            'ip' => 'IP',
            'date_income' => 'Дата поступления',
            'date_change' => 'Дата изменения',
            'status' => 'Статус лида',
            'system_data' => 'Лог',
            'type' => 'Тип лида',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'region' => 'Регион',
            'city' => 'Город',
            'comments' => 'Комментарии',
            'params' => 'Параметры лида',
            'auction_price' => 'Цена аукциона',
            'cc_check' => 'Проверен КЦ',
            'sms_check' => 'Проверен по SMS',
            'autocall_check' => 'Пришел с прозвона',
            'opens' => 'Отправки в КЦ'
        ];
        #$def = array_merge($def, $labels);
        return $def;
    }

    public function getLeadsParamsValues()
    {
        return $this->hasMany(LeadsParamsValues::className(), ['lead' => 'id']);
    }

    /**
     * Gets query for [[LeadsSentReports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsSentReports()
    {
        return $this->hasMany(LeadsSentReport::className(), ['lead_id' => 'id'])->orderBy('leads_sent_report.id desc');
    }

    public function getXlsx()
    {
        return $this->hasMany(LeadsSentReport::className(), ['lead_id' => 'id'])->select(['leads_sent_report.id', 'leads_sent_report.client_id', 'leads_sent_report.order_id', 'leads_sent_report.lead_id'])->orderBy('leads_sent_report.id desc');
    }

    public function getWaste() {
        return $this->hasMany(LeadsSentReport::className(), ['lead_id' => 'id'])->where(['leads_sent_report.status' => 'брак'])->orderBy('leads_sent_report.id desc');
    }

    public function getOpens() {
        return $this->hasMany(LeadsActions::class, ['lead_id' => 'id'])->where(['leads_actions.lead_type' => 'lead']);
    }
}
