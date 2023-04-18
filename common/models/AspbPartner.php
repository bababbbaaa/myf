<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_partner".
 *
 * @property int $id ID
 * @property string|null $name Наименование
 * @property string|null $phone Номер телефона
 * @property string|null $date Дата добавления
 */
class AspbPartner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['name', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'phone' => 'Номер телефона',
            'date' => 'Дата добавления',
        ];
    }
}
