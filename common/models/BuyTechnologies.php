<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "buy_technologies".
 *
 * @property int $id ID
 * @property int $user_id ID пользователя
 * @property int $technologies_id ID технологии
 * @property int $sale Покупка со скидкой
 * @property string $date Дата покупки
 */
class BuyTechnologies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buy_technologies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'technologies_id'], 'required'],
            [['user_id', 'technologies_id', 'sale'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'technologies_id' => 'ID технологии',
            'sale' => 'Покупка со скидкой',
            'date' => 'Дата покупки',
        ];
    }
}
