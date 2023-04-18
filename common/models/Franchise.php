<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "franchise_add".
 *
 * @property int $id ID
 * @property int $is_active Активность франшизы
 * @property string|null $category Категория
 * @property float $price Цена (инвестиции)
 * @property string $name Название
 * @property string $vendor Поставщик
 * @property string $render_data Данные рендера
 * @property string $date Дата
 * @property string $link Ссылка
 * @property string $meta_keywords Ключи
 * @property string $meta_description Описание
 */
class Franchise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franchise_add';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'name', 'render_data', 'link', 'meta_keywords', 'meta_description'], 'required'],
            [['price'], 'number'],
            [['is_active'], 'integer'],
            [['date'], 'safe'],
            [['render_data', 'date'], 'string'],
            [['category', 'name', 'vendor', 'link', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'price' => 'Цена (инвестиции)',
            'name' => 'Название',
            'vendor' => 'Поставщик (высота 50px, ширина не более 200px)',
            'render_data' => 'Данные рендера',
            'link' => 'Ссылка',
            'date' => 'Дата',
            'meta_description' => 'Описание МЕТА',
            'meta_keywords' => 'Ключи МЕТА',
            'is_active' => 'Франшиза активна'
        ];
    }

    public function getPrice() {
        return $this->hasMany(FranchisePackage::class, ['franchise_id' => 'id'])->min('price');
    }
}
