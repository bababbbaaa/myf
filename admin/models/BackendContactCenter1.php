<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "backend_contact_center1".
 *
 * @property string $date
 * @property int $id
 * @property string $source
 * @property string|null $name
 * @property string $phone
 * @property string|null $region
 * @property string|null $summ
 * @property string|null $commentary
 * @property string|null $callback_time
 * @property string|null $status
 * @property int $send
 * @property string|null $operator
 * @property string|null $pros
 * @property string|null $income
 * @property string|null $utm_source
 * @property string|null $utm_campaign
 * @property string|null $stage_status
 * @property string|null $final_status_date
 * @property string|null $log
 * @property int|null $decrease
 * @property int $old
 * @property int|null $gmt
 * @property string|null $ipoteka
 * @property string|null $additional
 * @property string|null $cc_type
 */
class BackendContactCenter1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_contact_center1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'final_status_date'], 'safe'],
            [['phone'], 'required'],
            [['status', 'stage_status', 'log', 'additional'], 'string'],
            [['send', 'decrease', 'old', 'gmt'], 'integer'],
            [['source', 'name', 'phone', 'region', 'summ', 'commentary', 'callback_time', 'operator', 'pros', 'income', 'utm_source', 'utm_campaign', 'ipoteka', 'cc_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'id' => 'ID',
            'source' => 'Source',
            'name' => 'Name',
            'phone' => 'Phone',
            'region' => 'Region',
            'summ' => 'Summ',
            'commentary' => 'Commentary',
            'callback_time' => 'Callback Time',
            'status' => 'Status',
            'send' => 'Send',
            'operator' => 'Operator',
            'pros' => 'Pros',
            'income' => 'Income',
            'utm_source' => 'Utm Source',
            'utm_campaign' => 'Utm Campaign',
            'stage_status' => 'Stage Status',
            'final_status_date' => 'Final Status Date',
            'log' => 'Log',
            'decrease' => 'Decrease',
            'old' => 'Old',
            'gmt' => 'Gmt',
            'ipoteka' => 'Ipoteka',
            'additional' => 'Additional',
            'cc_type' => 'Cc Type',
        ];
    }
}
