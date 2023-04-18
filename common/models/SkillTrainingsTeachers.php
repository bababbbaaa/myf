<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_teachers".
 *
 * @property int $id ID
 * @property string $name ФИО
 * @property string $photo Фото преподавателя
 * @property string $date Дата создания
 */
class SkillTrainingsTeachers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_teachers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'photo'], 'required'],
            [['date'], 'safe'],
            [['name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'photo' => 'Фото преподавателя',
            'date' => 'Дата создания',
        ];
    }
}
