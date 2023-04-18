<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "db_phones".
 *
 * @property int $id
 * @property int $first
 * @property int $second
 * @property int $third
 * @property string $region
 */
class DbPhones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'db_phones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first', 'second', 'third', 'region'], 'required'],
            [['first', 'second', 'third'], 'integer'],
            [['region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first' => 'First',
            'second' => 'Second',
            'third' => 'Third',
            'region' => 'Region',
        ];
    }
}
