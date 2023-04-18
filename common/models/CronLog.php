<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cron_log".
 *
 * @property int $id
 * @property string $date
 * @property string $log
 * @property string $action
 */
class CronLog extends \yii\db\ActiveRecord
{

    const TYPE_QUEUE = 'queue';

    public static function returnName($action) {
        switch ($action) {
            default:
            case self::TYPE_QUEUE:
                return "<b><span style='color: #2b569a'>Очередь лидов</span></b>";
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cron_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['log', 'action'], 'required'],
            [['log', 'action'], 'string'],
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
            'log' => 'Log',
            'action' => 'Action',
        ];
    }
}
