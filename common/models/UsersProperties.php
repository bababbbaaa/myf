<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_properties".
 *
 * @property int $id
 * @property int $user_id
 * @property string $params
 */
class UsersProperties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'params'], 'required'],
            [['user_id'], 'integer'],
            [['params'], 'string'],
        ];
    }

    public function asArrayProps() {
        return json_decode($this->params, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'params' => 'Параметры',
        ];
    }
}
