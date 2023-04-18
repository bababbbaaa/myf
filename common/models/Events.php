<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $type
 * @property int $price
 * @property int $main_page
 * @property string|null $main_page_text
 * @property string $event_date
 * @property string $event_city
 * @property int $preview_text
 * @property int $active
 * @property string $date
 * @property string|null $img
 * @property string|null $event_finish_date
 * @property string|null $category
 * @property string|null $poster
 * @property string|null $text_color
 * @property string|null $main_page_text_header
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link', 'type', 'preview_text', 'title', 'description', 'keywords'], 'required'],
            [['main_page', 'active', 'price'], 'integer'],
            [['date', 'event_date', 'event_finish_date'], 'safe'],
            [['name', 'link', 'type', 'main_page_text', 'event_city',
                'preview_text', 'img', 'category', 'poster', 'main_page_text_header', 'text_color'], 'string', 'max' => 255],
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
            'link' => 'Ссылка',
            'type' => 'Тип',
            'price' => 'Цена участия (не обязательно)',
            'main_page' => 'На главной',
            'main_page_text' => 'Текст на главной',
            'event_date' => 'Дата события',
            'event_city' => 'Город события',
            'preview_text' => 'Превью текст',
            'date' => 'Дата добавления',
            'active' => 'Активность',
            'img' => 'Изображение',
            'event_finish_date' => 'Дата окончания',
            'category' => 'Категория',
            'poster' => 'Постер',
            'main_page_text_header' => 'Заголовок на главной',
            'text_color' => 'Цвет текста',
            'title' => 'Тайтл',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
        ];
    }
}
