<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_articles".
 *
 * @property int $id
 * @property string $category
 * @property string $image
 * @property string $title
 * @property string $text
 * @property string $date
 * @property string $link
 */
class SkillArticles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'image', 'title', 'text', 'link'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['category', 'image', 'title', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'image' => 'Image',
            'title' => 'Title',
            'text' => 'Text',
            'date' => 'Date',
            'link' => 'Link',
        ];
    }
}
