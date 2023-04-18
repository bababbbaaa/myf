<?php

namespace common\models;

use common\behaviors\XlsxBehavior;
use Yii;

/**
 * This is the model class for table "leads".
 *
 * @property int $id ID
 * @property string $source
 * @property string|null $utm_source
 * @property string|null $utm_campaign
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
 * @property float $auction_price Цена в аукционе
 * @property integer $cc_check Проверен КЦ
 * @property integer $sms_check Проверен по СМС
 * @property integer $autocall_check Пришел с обзвона
 * @property integer $bx_sent Отправлен в BX24
 *
 * @property LeadsParamsValues[] $leadsParamsValues
 */
class LeadsRead extends \yii\db\ActiveRecord
{
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
            [['date_income', 'date_change'], 'safe'],
            [['system_data', 'comments', 'params'], 'string'],
            [['cc_check', 'sms_check', 'autocall_check', 'bx_sent'], 'integer'],
            [['auction_price'], 'number'],
            [['source', 'utm_source', 'utm_campaign', 'ip', 'status', 'type', 'name', 'email', 'phone', 'region', 'city'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'systemDataBehavior' => [
                'class' => XlsxBehavior::class,
                'property' => 'system_data',
                'jsonField' => 'system_data',
            ],
            'paramsBehavior' => [
                'class' => XlsxBehavior::class,
                'property' => 'params',
                'jsonField' => 'params',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
            'system_data' => 'Системные параметры',
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
        ];
    }

    public static function xlsxColumnProperties() {
        $getAtt = new LeadsRead();
        $attributes = $getAtt->attributes();
        foreach ($attributes as $key => $item)
            if ($item === 'system_data' || $item === 'params')
                unset($attributes[$key]);
        $new = [
            [
                'attribute' => 'system_data',
                'format' => 'raw',
                'contentOptions' => [
                    'alignment' => [
                        'vertical' => 'center',
                    ],
                ],
            ],
            [
                'attribute' => 'params',
                'format' => 'raw',
                'contentOptions' => [
                    'alignment' => [
                        'vertical' => 'center',
                    ],
                ],
            ]
        ];
        return array_merge($attributes, $new);
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
}
