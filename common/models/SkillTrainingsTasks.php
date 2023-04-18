<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_tasks".
 *
 * @property int $id ID
 * @property int $block_id ID блока
 * @property int $training_id ID курса
 * @property int $task_id ID курса
 * @property int|null $sort_order Сортировка
 * @property string|null $content Контент
 * @property string|null $materials Материалы
 * @property string|null $questions Вопросы
 * @property string $date Дата
 *
 * @property SkillTrainingsBlocks $block
 * @property SkillTrainings $training
 */
class SkillTrainingsTasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id', 'training_id', 'questions', 'sort_order'], 'required'],
            [['block_id', 'training_id', 'sort_order'], 'integer'],
            [['content', 'materials', 'questions'], 'string'],
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
            'block_id' => 'Блок курса',
            'training_id' => 'Курс',
            'sort_order' => 'Сортировка',
            'content' => 'Контент',
            'materials' => 'Материалы',
            'questions' => 'Вопросы',
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
