<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "integrations_special_params".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $assigned_param
 */
class IntegrationsSpecialParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integrations_special_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'assigned_param'], 'required'],
            [['name', 'description', 'assigned_param'], 'string', 'max' => 255],
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
            'assigned_param' => 'Assigned Param',
        ];
    }
}
