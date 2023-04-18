<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bavaria_bot_messages".
 *
 * @property int $id
 * @property string $tg_user_id
 * @property string $username
 * @property string $stage
 * @property string|null $text
 * @property int $created_at
 * @property string $status
 */
class BavariaBotMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bavaria_bot_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tg_user_id', 'created_at'], 'required'],
            [['text'], 'string'],
            [['created_at'], 'integer'],
            [['tg_user_id', 'status', 'username', 'stage'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tg_user_id' => 'Tg User ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
