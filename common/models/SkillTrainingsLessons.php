<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_lessons".
 *
 * @property int $id ID
 * @property string $name Название
 * @property string $lesson_link Ссылка на урок
 * @property int $training_id Курс
 * @property int $block_id Блок
 * @property int $sort_order Порядок сортировки в блоке
 * @property string|null $main_text Основной текст
 * @property string|null $video Видео
 * @property string|null $material Материалы
 * @property string|null $content Конспектная часть
 * @property string $date Дата
 *
 * @property SkillTrainingsBlocks $block
 * @property SkillTrainings $training
 */
class SkillTrainingsLessons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lesson_link', 'training_id', 'block_id', 'sort_order'], 'required'],
            [['training_id', 'block_id', 'sort_order'], 'integer'],
            [['main_text', 'content', 'material'], 'string'],
            [['date'], 'safe'],
            [['name', 'lesson_link'], 'string', 'max' => 255],
            [['video'], 'string', 'max' => 1023],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillTrainingsBlocks::className(), 'targetAttribute' => ['block_id' => 'id']],
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
            'name' => 'Название',
            'lesson_link' => 'Ссылка на урок',
            'training_id' => 'Курс',
            'block_id' => 'Блок',
            'sort_order' => 'Порядок сортировки в блоке',
            'main_text' => 'Основной текст',
            'video' => 'Видео',
            'material' => 'Материалы',
            'content' => 'Конспектная часть',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[Block]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(SkillTrainingsBlocks::className(), ['id' => 'block_id']);
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
}
