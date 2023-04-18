<?php

namespace app\models;

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
 * @property string $description Описание
 * @property string $advantages Преимущества
 */
class Offers extends \yii\db\ActiveRecord
{
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
            [['image', 'category', 'category_link', 'regions', 'name', 'price', 'description', 'advantages'], 'required'],
            [['regions', 'description', 'advantages'], 'string'],
            [['price'], 'number'],
            [['image', 'category', 'category_link', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'category' => 'Category',
            'category_link' => 'Category Link',
            'regions' => 'Regions',
            'name' => 'Name',
            'price' => 'Price',
            'description' => 'Description',
            'advantages' => 'Advantages',
        ];
    }
}
