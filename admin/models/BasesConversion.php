<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_conversion".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $type
 */
class BasesConversion extends \yii\db\ActiveRecord
{


    public $total;
    public $is1Total;
    public $isCcTotal;
    public $is250Total;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_conversion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['date'], 'safe'],
            [['name', 'type'], 'string', 'max' => 255],
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
            'date' => 'Date',
            'type' => 'Type',
        ];
    }
}
