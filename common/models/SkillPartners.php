<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_partners".
 *
 * @property int $id ID
 * @property string $name Название
 * @property string $content Описание
 * @property string $photo Фотография (лого)
 * @property string $date Дата
 * @property string $link Ссылка партнера
 *
 * @property SkillTrainings[] $skillTrainings
 * @property integer $courseCount
 */
class SkillPartners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'photo', 'link'], 'required'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['name', 'photo', 'link'], 'string', 'max' => 255],
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
            'name' => 'Название',
            'content' => 'Описание',
            'photo' => 'Фотография (лого)',
            'date' => 'Дата',
            'link' => 'Ссылка партнера',
        ];
    }

    /**
     * Gets query for [[SkillTrainings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainings()
    {
        return $this->hasMany(SkillTrainings::className(), ['partner_link' => 'link']);
    }
    public function getCourseCount()
    {
        return $this->hasMany(SkillTrainings::className(), ['partner_link' => 'link'])->where(['type' => 'Курс'])->count();
    }

}
