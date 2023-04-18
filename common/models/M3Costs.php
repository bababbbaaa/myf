<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m3_costs".
 *
 * @property int $id
 * @property int $project_id
 * @property float|null $value
 * @property string|null $description
 * @property string $date
 */
class M3Costs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_costs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id'], 'required'],
            [['project_id'], 'integer'],
            [['value'], 'number'],
            [['description'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'value' => 'Value',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }
}
