<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_ay".
 *
 * @property int $id ID
 * @property string|null $fio ФИО
 * @property string|null $reg_number Регистрационный номер
 * @property string|null $address Почтовый адресс
 * @property string|null $email Email
 * @property string|null $date Дата добавления
 */
class AspbAy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_ay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['fio', 'reg_number', 'email'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'reg_number' => 'Регистрационный номер',
            'address' => 'Почтовый адресс',
            'email' => 'Email',
            'date' => 'Дата добавления',
        ];
    }
}
