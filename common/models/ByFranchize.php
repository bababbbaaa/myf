<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "by_franchize".
 *
 * @property int $id ID
 * @property int $user_id ID юзера
 * @property int $franchize_id ID франшизы
 * @property string $date Дата покупки
 * @property int $package_id ID Пакета
 * @property string $type Тип покупки
 */
class ByFranchize extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'by_franchize';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'franchize_id', 'package_id', 'type'], 'required'],
            [['user_id', 'franchize_id', 'package_id'], 'integer'],
            [['date'], 'safe'],
            [['type'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID юзера',
            'franchize_id' => 'ID франшизы',
            'date' => 'Дата покупки',
            'package_id' => 'ID Пакета',
            'type' => 'Тип покупки',
        ];
    }
}
