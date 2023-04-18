<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_types".
 *
 * @property int $id ID
 * @property string $image Картинка
 * @property string $category Категория
 * @property string $category_link Ссылка на категорию
 * @property string $regions Регионы
 * @property string $name Название
 * @property float $price Цена
 * @property int $lead_count Количество лидов
 * @property integer $hot Горячий оффер
 * @property integer $active Активность оффера
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
class LeadTypes extends \yii\db\ActiveRecord
{

    public $geo = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'category', 'category_link', 'regions', 'name', 'price', 'description', 'advantages', 'link'], 'required'],
            [['regions', 'description', 'advantages', 'params' , 'geo'], 'string'],
            [['price'], 'number'],
            [['hot', 'active', 'lead_count'], 'integer'],
            [['image', 'category', 'category_link', 'name', 'link', 'og_title', 'og_description', 'og_image', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
        ];
    }

    public static function chargebackRegions() {
        return [
            'Россия' => 'Россия',
            'Европа' => 'Европа',
            'СНГ' => 'СНГ',
            'Любой' => 'Любой',
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
            'category_link' => 'Ссылка',
            'regions' => 'Регионы',
            'name' => 'Название',
            'price' => 'Цена',
            'lead_count' => 'Количество лидов',
            'description' => 'Описание',
            'advantages' => 'Особенности',
            'params' => 'Параметры',
            'hot' => 'Горячий оффер',
            'active' => 'Активность оффера',
            'link' => 'Ссылка',
            'og_title' => 'OG-заголовок',
            'og_description' => 'OG-описание',
            'og_image' => 'OG-картинка',
            'meta_description' => 'МЕТА описание',
            'meta_keywords' => 'МЕТА ключи',
        ];
    }
}
