<?php

namespace common\models;

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
 * @property float $auction_price
 * @property int $cc_check
 * @property int $sms_check
 * @property int $autocall_check
 * @property int $bx_sent
 *
 * @property LeadsParamsValues[] $leadsParamsValues
 * @property LeadsSentReport[] $leadsSentReports
 */
class LeadsSave extends \yii\db\ActiveRecord
{

    public $date_lead;
    public $summ;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'ip', 'type', 'phone'], 'required'],
            [['date_income', 'date_change', 'date_lead', 'summ'], 'safe'],
            [['system_data', 'comments', 'params'], 'string'],
            [['auction_price'], 'number'],
            [['bx_sent'], 'integer'],
            [['cc_check', 'sms_check', 'autocall_check'], 'integer'],
            [['source', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_term', 'utm_title', 'utm_device_type', 'utm_age', 'utm_inst', 'utm_special', 'ip', 'status', 'type', 'name', 'email', 'phone', 'region', 'city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'utm_source' => 'Utm Source',
            'utm_campaign' => 'Utm Campaign',
            'utm_medium' => 'Utm Medium',
            'utm_content' => 'Utm Content',
            'utm_term' => 'Utm Term',
            'utm_title' => 'Utm Title',
            'utm_device_type' => 'Utm Device Type',
            'utm_age' => 'Utm Age',
            'utm_inst' => 'Utm Inst',
            'utm_special' => 'Utm Special',
            'ip' => 'IP',
            'date_income' => 'Дата поступления',
            'date_change' => 'Дата изменения',
            'status' => 'Статус лида',
            'system_data' => 'Системные параметры',
            'type' => 'Тип лида',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'region' => 'Регион',
            'city' => 'Город',
            'comments' => 'Комментарии',
            'params' => 'Параметры лида',
            'auction_price' => 'Auction Price',
            'cc_check' => 'Cc Check',
            'sms_check' => 'Sms Check',
            'autocall_check' => 'Autocall Check',
        ];
    }

    /**
     * Gets query for [[LeadsParamsValues]].
     *
     * @return \yii\db\ActiveQuery
     */
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
        return $this->hasMany(LeadsSentReport::className(), ['lead_id' => 'id']);
    }
}
