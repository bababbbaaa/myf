<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_lessons_alias".
 *
 * @property int $id ID
 * @property int $training_id ID курса
 * @property int $lesson_id ID урока
 * @property int $block_id ID блока
 * @property string $date Дата
 * @property int $user_id ID юзера
 */
class SkillTrainingsLessonsAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_lessons_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'lesson_id', 'block_id', 'user_id'], 'required'],
            [['training_id', 'lesson_id', 'block_id', 'user_id'], 'integer'],
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
            'training_id' => 'ID курса',
            'lesson_id' => 'ID урока',
            'block_id' => 'ID блока',
            'date' => 'Дата',
            'user_id' => 'ID юзера',
        ];
    }
}
