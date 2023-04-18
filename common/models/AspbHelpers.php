<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_helpers".
 *
 * @property int $id ID
 * @property string|null $fio ФИО
 * @property string|null $phone Телефон
 * @property string|null $date Дата добавления
 */
class AspbHelpers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_helpers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['fio', 'phone'], 'string', 'max' => 255],
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
            'phone' => 'Телефон',
            'date' => 'Дата добавления',
        ];
    }
}
