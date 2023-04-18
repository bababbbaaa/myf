<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_tests".
 *
 * @property int $id ID
 * @property int $block_id ID блока
 * @property int $name Название теста
 * @property int $sort_order Порядок сортировки в блоке
 * @property int $max_tries Количество попыток
 * @property int $training_id ID курса
 * @property string $content Контент
 * @property string $date Дата
 *
 * @property SkillTrainingsBlocks $block
 * @property SkillTrainings $training
 */
class SkillTrainingsTests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_tests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id', 'training_id', 'content', 'name', 'sort_order'], 'required'],
            [['block_id', 'max_tries', 'training_id', 'sort_order'], 'integer'],
            [['content'], 'string'],
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
            'block_id' => 'Блок',
            'name' => 'Название теста',
            'sort_order' => 'Порядок сортировки в блоке',
            'max_tries' => 'Количество попыток',
            'training_id' => 'Курс',
            'content' => 'Ответы',
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
