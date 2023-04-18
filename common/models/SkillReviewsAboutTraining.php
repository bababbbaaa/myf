<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_reviews_about_training".
 *
 * @property int $id ID
 * @property int $training_id Курс
 * @property string $name Имя
 * @property int|null $grade Оценка за курс
 * @property string $content Содержание отзыва
 * @property string $date Дата
 * @property string $photo Фотография
 *
 * @property SkillTrainings $training
 */
class SkillReviewsAboutTraining extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_reviews_about_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'name', 'content', 'photo'], 'required'],
            [['training_id', 'grade'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['name', 'photo'], 'string', 'max' => 255],
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
            'training_id' => 'Курс',
            'name' => 'Имя',
            'grade' => 'Оценка за курс',
            'content' => 'Содержание отзыва',
            'date' => 'Дата',
            'photo' => 'Фотография',
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
}
