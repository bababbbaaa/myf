<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_templates".
 *
 * @property int $id ID
 * @property string $image Картинка
 * @property string $category Категория
 * @property string $category_link Ссылка на категорию
 * @property string $regions Регионы
 * @property string $name Название
 * @property float $price Цена
 * @property integer $active Активность
 * @property string $description Описание
 * @property string $advantages Преимущества
 * @property string|null $params Параметры
 * @property string $link Ссылка
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property string $meta_description
 * @property string $meta_keywords
 */
class LeadTemplates extends \yii\db\ActiveRecord
{

    public $geo = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'category', 'category_link', 'regions', 'name', 'price', 'description', 'advantages', 'link'], 'required'],
            [['regions', 'description', 'advantages', 'params', 'geo'], 'string'],
            [['price'], 'number'],
            [['active'], 'integer'],
            [['image', 'category', 'category_link', 'name', 'link', 'og_title', 'og_description', 'og_image', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Картинка',
            'category' => 'Категория',
            'category_link' => 'Ссылка на категорию',
            'regions' => 'Регионы',
            'name' => 'Название',
            'price' => 'Цена',
            'description' => 'Описание',
            'advantages' => 'Преимущества',
            'params' => 'Параметры',
            'active' => 'Активность',
            'link' => 'Ссылка',
            'og_title' => 'OG-заголовок',
            'og_description' => 'OG-описание',
            'og_image' => 'OG-картинка',
            'meta_description' => 'МЕТА описание',
            'meta_keywords' => 'МЕТА ключи',
        ];
    }
}
