<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "backend_contact_center_chargeback".
 *
 * @property int $id
 * @property string $date
 * @property string|null $source
 * @property string|null $name
 * @property string $phone
 * @property string|null $region
 * @property string|null $type
 * @property string|null $summ
 * @property string|null $srok
 * @property string|null $sposob
 * @property string|null $callback_time
 * @property string|null $status
 * @property int $send
 * @property string|null $operator
 * @property string|null $comment
 * @property string|null $utm_source
 * @property string|null $utm_campaign
 */
class BackendContactCenterChargeback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_contact_center_chargeback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['phone'], 'required'],
            [['status', 'comment'], 'string'],
            [['send'], 'integer'],
            [['source', 'name', 'phone', 'region', 'type', 'summ', 'srok', 'sposob', 'callback_time', 'operator', 'utm_source', 'utm_campaign'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'source' => 'Source',
            'name' => 'Name',
            'phone' => 'Phone',
            'region' => 'Region',
            'type' => 'Type',
            'summ' => 'Summ',
            'srok' => 'Srok',
            'sposob' => 'Sposob',
            'callback_time' => 'Callback Time',
            'status' => 'Status',
            'send' => 'Send',
            'operator' => 'Operator',
            'comment' => 'Comment',
            'utm_source' => 'Utm Source',
            'utm_campaign' => 'Utm Campaign',
        ];
    }
}
