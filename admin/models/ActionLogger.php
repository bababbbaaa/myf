<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "action_logger".
 *
 * @property int $id
 * @property int $user
 * @property string $controller
 * @property string $action
 * @property string $params
 * @property string $date
 */
class ActionLogger extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action_logger';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'controller', 'action', 'params'], 'required'],
            [['user'], 'integer'],
            [['params'], 'string'],
            [['date'], 'safe'],
            [['controller', 'action'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'controller' => 'Controller',
            'action' => 'Action',
            'params' => 'Params',
            'date' => 'Date',
        ];
    }
}
