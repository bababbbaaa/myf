<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $link
 * @property string $title
 * @property string|null $author
 * @property string|null $source
 * @property string $date
 * @property string $content
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property string $search_tag
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public static $tags = [
        "общие" => "общие",
        "главная" => "главная",
        "маркетинг" => "маркетинг",
        "вебмастер" => "вебмастер",
        "франшиза" => "франшиза",
        "скиллфорс" => "скиллфорс",
        "девфорс" => "девфорс",
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'title', 'content', 'meta_description', 'meta_keywords', 'tag'], 'required'],
            [['date'], 'safe'],
            [['content', 'search_tag'], 'string'],
            [['link', 'title', 'author', 'source', 'meta_description', 'meta_keywords', 'tag', 'og_description', 'og_title', 'og_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Ссылка',
            'title' => 'Заголовок',
            'search_tag' => 'Теги поиска (для девфорс)',
            'author' => 'Автор',
            'source' => 'Источник',
            'date' => 'Дата',
            'content' => 'Контент новости',
            'meta_description' => 'Описание МЕТА',
            'meta_keywords' => 'Ключи МЕТА',
            'tag' => 'Метка',
            'og_description' => 'OG-описание',
            'og_title' => 'OG-заголовок',
            'og_image' => 'OG-картинка',
        ];
    }
}
