<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_funds".
 *
 * @property int $id
 * @property float $value
 * @property string $type
 * @property string $region
 * @property string $date
 */
class BasesFunds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_funds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'type', 'region'], 'required'],
            [['value'], 'number'],
            [['date'], 'safe'],
            [['type', 'region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Сумма',
            'type' => 'Тип',
            'region' => 'Регион',
            'date' => 'Дата',
        ];
    }
}
