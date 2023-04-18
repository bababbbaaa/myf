<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_processor".
 *
 * @property int $id ID
 * @property string $data Лог
 * @property int $lead_id
 * @property string $entity
 * @property string $date Дата
 * @property string $status Тип
 */
class LogProcessor extends \yii\db\ActiveRecord
{

    public static function returnEntity($entity) {
        $str = $entity;
        if (stripos($str, 'order_') !== false)
            return ['type' => 'orders', 'id' => str_replace('order_', '', $str)];
        else
            return ['type' => 'clients', 'id' => str_replace('client_', '', $str)];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_processor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'lead_id', 'entity'], 'required'],
            [['data', 'status'], 'string'],
            [['lead_id'], 'integer'],
            [['date'], 'safe'],
            [['entity'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Лог',
            'lead_id' => 'Lead ID',
            'entity' => 'Entity',
            'date' => 'Дата',
            'status' => 'Тип',
        ];
    }
}
