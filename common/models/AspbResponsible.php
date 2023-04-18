<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_responsible".
 *
 * @property int $id ID
 * @property string|null $fio ФИО
 * @property string|null $date Дата добавления
 */
class AspbResponsible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_responsible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['fio'], 'string', 'max' => 255],
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
            'date' => 'Дата добавления',
        ];
    }
}
