<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_backdoor_handle".
 *
 * @property int $id
 * @property string $region
 * @property string $date
 * @property string $type
 */
class BasesBackdoorHandle extends \yii\db\ActiveRecord
{

    public $is_250;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_backdoor_handle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region', 'type'], 'required'],
            [['date'], 'safe'],
            [['is_250'], 'integer'],
            [['region', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
            'date' => 'Date',
            'type' => 'Type',
        ];
    }
}
