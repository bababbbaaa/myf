<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "statistics_daily".
 *
 * @property int $id
 * @property int $order_id
 * @property string $date
 * @property string $date_time
 * @property int $count
 * @property int $min
 * @property int $min_order
 * @property float $percent
 * @property float $percent_order
 */
class StatisticsDaily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statistics_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'date', 'count', 'min', 'min_order', 'percent', 'percent_order'], 'required'],
            [['order_id', 'count', 'min', 'min_order'], 'integer'],
            [['date_time'], 'safe'],
            [['percent', 'percent_order'], 'number'],
            [['date'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'date' => 'Date',
            'date_time' => 'Date Time',
            'count' => 'Count',
            'min' => 'Min',
            'min_order' => 'Min Order',
            'percent' => 'Percent',
            'percent_order' => 'Percent Order',
        ];
    }
}
