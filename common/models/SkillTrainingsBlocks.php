<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_blocks".
 *
 * @property int $id ID
 * @property string $name Название блока
 * @property string $block_link Ссылка на блок
 * @property int|null $sort_order Порядок сортировки
 * @property int $training_id Курс
 * @property string|null $small_description Малое описание
 *
 * @property SkillTrainings $training
 * @property SkillTrainingsLessons[] $skillTrainingsLessons
 */
class SkillTrainingsBlocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_blocks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'block_link', 'training_id'], 'required'],
            [['sort_order', 'training_id'], 'integer'],
            [['name', 'block_link', 'small_description'], 'string', 'max' => 255],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillTrainings::className(), 'targetAttribute' => ['training_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название блока',
            'block_link' => 'Ссылка на блок',
            'sort_order' => 'Порядок сортировки',
            'training_id' => 'Курс',
            'small_description' => 'Малое описание',
        ];
    }

    /**
     * Gets query for [[Training]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTraining()
    {
        return $this->hasOne(SkillTrainings::className(), ['id' => 'training_id']);
    }

    /**
     * Gets query for [[SkillTrainingsLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainingsLessons()
    {
        return $this->hasMany(SkillTrainingsLessons::className(), ['block_id' => 'id'])->orderBy('sort_order');
    }
}
