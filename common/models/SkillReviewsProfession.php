<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_reviews_profession".
 *
 * @property int $id ID
 * @property string $name Имя
 * @property string $whois Должность
 * @property string $content Содержание отзыва
 * @property string $date Дата
 * @property string $photo Фотография
 */
class SkillReviewsProfession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_reviews_profession';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'whois', 'content', 'photo'], 'required'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['name', 'whois', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'whois' => 'Должность',
            'content' => 'Содержание отзыва',
            'date' => 'Дата',
            'photo' => 'Фотография',
        ];
    }
}
