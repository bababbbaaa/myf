<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_input".
 *
 * @property int $id
 * @property string $date
 * @property string $source
 * @property string $info
 */
class LogInput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['source', 'info'], 'required'],
            [['info'], 'string'],
            [['source'], 'string', 'max' => 255],
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
            'source' => 'Source',
            'info' => 'Info',
        ];
    }
}
