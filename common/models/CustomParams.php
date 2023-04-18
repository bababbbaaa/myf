<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "custom_params".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $date
 * @property string $entity
 * @property string $type
 * @property string|null $special_input
 */
class CustomParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'custom_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'entity', 'type'], 'required'],
            [['date'], 'safe'],
            [['name', 'description', 'entity', 'type', 'special_input'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'date' => 'Date',
            'entity' => 'Entity',
            'type' => 'Type',
            'special_input' => 'Special Input',
        ];
    }
}
