<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "backdoor_hooks".
 *
 * @property int $id
 * @property string $url
 * @property int $user_id
 * @property int $status
 * @property int $first_try_passed
 * @property string $date
 */
class BackdoorHooks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backdoor_hooks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'user_id'], 'required'],
            [['url'], 'string'],
            [['user_id', 'status', 'first_try_passed'], 'integer'],
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
            'url' => 'Url',
            'user_id' => 'User ID',
            'status' => 'Status',
            'first_try_passed' => 'First Try Passed',
            'date' => 'Date',
        ];
    }
}
