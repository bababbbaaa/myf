<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_category".
 *
 * @property int $id ID
 * @property string $name Название категории
 * @property string $link Ссылка
 * @property string $date Дата
 * @property string $image Картинка
 *
 * @property SkillTrainings[] $skillTrainings
 * @property int $skillTrainingsCourseCount
 * @property int $skillTrainingsWebCount
 * @property int $skillTrainingsIntensiveCount
 */
class SkillTrainingsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['date'], 'safe'],
            [['name', 'link', 'image'], 'string', 'max' => 255],
            [['link'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название категории',
            'link' => 'Ссылка',
            'date' => 'Дата',
            'image' => 'Картинка',
        ];
    }

    /**
     * Gets query for [[SkillTrainings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainings()
    {
        return $this->hasMany(SkillTrainings::className(), ['category_id' => 'id']);
    }
    /**
     * Gets query for [[SkillTrainingsCourseCount]].
     */
    public function getSkillTrainingsCourseCount()
    {
        return $this->hasMany(SkillTrainings::className(), ['category_id' => 'id'])->where(['type' => 'Курс'])->count();
    }
    /**
     * Gets query for [[SkillTrainingsWebCount]].
     */
    public function getSkillTrainingsWebCount()
    {
        return $this->hasMany(SkillTrainings::className(), ['category_id' => 'id'])->where(['type' => 'Вебинар'])->count();
    }
    /**
     * Gets query for [[SkillTrainingsIntensiveCount]].
     */
    public function getSkillTrainingsIntensiveCount()
    {
        return $this->hasMany(SkillTrainings::className(), ['category_id' => 'id'])->where(['type' => 'Интенсив'])->count();
    }

    public function getSkillTrainingsCount()
    {
        return $this->hasMany(SkillTrainings::className(), ['category_id' => 'id'])->count();
    }
}
