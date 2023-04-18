<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m3_auth".
 *
 * @property int $id
 * @property int $uid
 * @property string $username
 * @property string $hash
 */
class M3Auth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'username', 'hash'], 'required'],
            [['uid'], 'integer'],
            [['username', 'hash'], 'string', 'max' => 255],
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
            'hash' => 'Hash',
        ];
    }
}
