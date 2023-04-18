<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mf_bot_counter".
 *
 * @property int $id
 * @property string $date
 * @property int $count_anketa
 * @property int $count_won
 */
class MfBotCounter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mf_bot_counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['count_anketa', 'count_won'], 'required'],
            [['count_anketa', 'count_won'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'count_anketa' => 'Count Anketa',
            'count_won' => 'Count Won',
        ];
    }
}
