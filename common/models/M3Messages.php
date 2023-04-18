<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m3_messages".
 *
 * @property int $id
 * @property int $uid
 * @property string|null $username
 * @property string|null $message
 * @property string $task
 * @property string $date
 * @property string $status
 */
class M3Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'task'], 'required'],
            [['uid'], 'integer'],
            [['message', 'status'], 'string'],
            [['date'], 'safe'],
            [['username', 'task'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'message' => 'Message',
            'task' => 'Task',
            'date' => 'Date',
        ];
    }
}
