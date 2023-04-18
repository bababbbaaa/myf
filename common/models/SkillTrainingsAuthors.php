<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_authors".
 *
 * @property int $id ID
 * @property string $name ФИО
 * @property string $link Ссылка
 * @property string $small_description Малое описание
 * @property string $photo Фото
 * @property string $about Об авторе
 * @property string $specs Специализация
 * @property string|null $video Видео
 * @property int $practice Опыт
 * @property string|null $comment_article Комментарий (заголовок)
 * @property string|null $comment_text Комментарий (цитата)
 * @property string $date Дата
 *
 * @property SkillTrainings[] $skillTrainings
 */
class SkillTrainingsAuthors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link', 'small_description', 'photo', 'about', 'specs', 'practice'], 'required'],
            [['about', 'specs'], 'string'],
            [['date'], 'safe'],
            [['practice'], 'default', 'value' => '0'],
            [['name', 'link', 'small_description', 'photo', 'video', 'comment_article', 'comment_text'], 'string', 'max' => 255],
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
            'name' => 'ФИО',
            'link' => 'Ссылка',
            'small_description' => 'Малое описание',
            'photo' => 'Фото',
            'about' => 'Об авторе',
            'specs' => 'Специализация',
            'video' => 'Видео',
            'practice' => 'Опыт',
            'comment_article' => 'Комментарий (заголовок)',
            'c' => 'Комментарий (цитата)',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[SkillTrainings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainings()
    {
        return $this->hasMany(SkillTrainings::className(), ['author_id' => 'id']);
    }

}
