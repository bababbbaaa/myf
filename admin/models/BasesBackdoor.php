<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_backdoor".
 *
 * @property int $id
 * @property string $region
 * @property string $date
 * @property string $type
 */
class BasesBackdoor extends \yii\db\ActiveRecord
{
    public $is_250;
    public $is_cc;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_backdoor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region', 'type'], 'required'],
            [['date'], 'safe'],
            [['is_250', 'is_cc'], 'integer'],
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
            'region' => 'Регион',
            'date' => 'Дата',
            'type' => 'Тип',
        ];
    }
}
