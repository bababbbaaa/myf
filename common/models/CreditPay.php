<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "credit_pay".
 *
 * @property int $id id
 * @property int $user_id ID пользователя
 * @property string $date Дата оплаты
 * @property int $price Сумма кредита
 * @property int $status Статус оплаты
 */
class CreditPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credit_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'price'], 'required'],
            [['user_id', 'price', 'status'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'user_id' => 'ID пользователя',
            'date' => 'Дата оплаты',
            'price' => 'Сумма кредита',
            'status' => 'Статус оплаты',
        ];
    }
}
