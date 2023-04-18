<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jobs_alias".
 *
 * @property int $id ID
 * @property int $user_id ID пользователя
 * @property int $jobs_id ID вакансии
 * @property string $date Дата отклика
 */
class JobsAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'jobs_id'], 'required'],
            [['user_id', 'jobs_id'], 'integer'],
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
            'user_id' => 'ID пользователя',
            'jobs_id' => 'ID вакансии',
            'date' => 'Дата отклика',
        ];
    }
}
