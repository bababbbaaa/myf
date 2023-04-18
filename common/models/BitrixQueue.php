<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "f_bitrix_queue".
 *
 * @property int $id
 * @property string $department
 * @property int $current_id
 * @property string $date
 * @property string $type
 */
class BitrixQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_bitrix_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department', 'current_id', 'type'], 'required'],
            [['department'], 'string'],
            [['current_id'], 'integer'],
            [['date'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department' => 'Department',
            'current_id' => 'Current ID',
            'date' => 'Date',
            'type' => 'Type',
        ];
    }
}
