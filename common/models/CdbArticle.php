<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cdb_article".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $link
 * @property string $date
 * @property string|null $img
 * @property string|null $minimum_status
 * @property int|null $price
 * @property string $author
 * @property string|null $tags
 * @property int $views
 * @property int $likes
 * @property int $downloads
 */
class CdbArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdb_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'subcategory_id', 'price', 'views', 'likes', 'downloads'], 'integer'],
            [['title', 'description', 'text', 'link'], 'required'],
            [['description', 'text'], 'string'],
            [['date'], 'safe'],
            [['title', 'link', 'img', 'minimum_status', 'author', 'tags'], 'string', 'max' => 255],
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
            'category_id' => 'ID категрии',
            'subcategory_id' => 'ID подкатегрии',
            'title' => 'Название',
            'description' => 'Описание',
            'text' => 'Контент',
            'link' => 'Ссылка',
            'date' => 'Дата',
            'img' => 'Изображение',
            'minimum_status' => 'Статус',
            'price' => 'Цена',
            'author' => 'Автор',
            'tags' => 'Теги',
            'views' => 'Просмтотры',
            'likes' => 'Лайки',
            'downloads' => 'Загрузки',
        ];
    }
}
