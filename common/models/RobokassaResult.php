<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "robokassa_result".
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $entity
 * @property string|null $entity_id
 * @property string|null $crc
 * @property string|null $status
 * @property string|null $summ
 * @property string|null $inv
 * @property string|null $description
 * @property string $date
 */
class RobokassaResult extends \yii\db\ActiveRecord
{

    const
        STATUS_GOT = 'получен',
        STATUS_CONFIRMED = 'подтвержден',
        STATUS_ERROR = 'ошибка';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'robokassa_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['user_id', 'entity', 'entity_id', 'crc', 'status', 'summ', 'inv', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'entity_id' => 'ID сущности',
            'entity' => 'Сущность',
            'crc' => 'CRC',
            'status' => 'Статус',
            'summ' => 'Сумма',
            'inv' => 'Инвойс',
            'description' => 'Описание',
            'date' => 'Дата',
        ];
    }
}
