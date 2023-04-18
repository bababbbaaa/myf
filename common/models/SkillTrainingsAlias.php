<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_alias".
 *
 * @property int $id ID
 * @property int $user_id ID пользователя
 * @property int $course_id ID курса
 * @property string $date Дата покупки
 */
class SkillTrainingsAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id'], 'required'],
            [['user_id', 'course_id'], 'integer'],
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
            'course_id' => 'ID курса',
            'date' => 'Дата покупки',
        ];
    }
}
