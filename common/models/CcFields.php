<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cc_fields".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $lead_type
 * @property string|null $params
 */
class CcFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cc_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'lead_type'], 'required'],
            [['type', 'params'], 'string'],
            [['name', 'lead_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'type' => 'Тип поля',
            'lead_type' => 'Тип лидов',
            'params' => 'Параметры',
        ];
    }
}
