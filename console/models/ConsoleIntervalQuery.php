<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "console_interval_query".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $order_id
 * @property string $process_time
 * @property string $status
 * @property string|null $reason
 */
class ConsoleIntervalQuery extends \yii\db\ActiveRecord
{

    const STATUS_WAIT = 'ожидает';
    const STATUS_SUCCESS = 'успешно';
    const STATUS_ERROR = 'ошибка';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'console_interval_query';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'order_id'], 'required'],
            [['lead_id', 'order_id'], 'integer'],
            [['process_time'], 'safe'],
            [['status', 'reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'order_id' => 'Order ID',
            'process_time' => 'Process Time',
            'status' => 'Status',
            'reason' => 'Reason',
        ];
    }
}
