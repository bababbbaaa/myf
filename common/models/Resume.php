<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resume".
 *
 * @property int $id ID
 * @property int $user_id id пользователя
 * @property string $info Информация пользователя
 * @property string $date Дата создания
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'info'], 'required'],
            [['user_id'], 'integer'],
            [['info'], 'string'],
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
            'user_id' => 'id пользователя',
            'info' => 'Информация пользователя',
            'date' => 'Дата создания',
        ];
    }
}
