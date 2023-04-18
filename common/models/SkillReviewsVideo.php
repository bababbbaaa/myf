<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_reviews_video".
 *
 * @property int $id ID
 * @property string $title Заголовок
 * @property string $small_description Малое описание
 * @property string $video Ссылка на видео
 * @property string $date Дата
 */
class SkillReviewsVideo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_reviews_video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'small_description', 'video'], 'required'],
            [['date'], 'safe'],
            [['title', 'small_description', 'video'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'small_description' => 'Малое описание',
            'video' => 'Ссылка на видео',
            'date' => 'Дата',
        ];
    }
}
