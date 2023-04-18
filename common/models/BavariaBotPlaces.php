<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bavaria_bot_places".
 *
 * @property int $id
 * @property string $name
 * @property int $available_count
 */
class BavariaBotPlaces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bavaria_bot_places';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'available_count'], 'required'],
            [['available_count'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'available_count' => 'Available Count',
        ];
    }
}
