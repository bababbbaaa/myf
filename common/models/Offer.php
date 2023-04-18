<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offer".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $token
 * @property string $category
 * @property string $description
 * @property string|null $properties
 * @property float $price
 * @property string|null $date
 * @property string $logo
 * @property string $type
 * @property string $area
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link', 'token', 'category', 'description', 'price', 'logo', 'type', 'area'], 'required'],
            [['description', 'properties', 'type'], 'string'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['name', 'link', 'category', 'logo', 'area'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 128],
            [['token'], 'unique'],
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
            'token' => 'Уникальный ключ оффера',
            'category' => 'Категория',
            'description' => 'Описание',
            'properties' => 'Параметры оффера',
            'price' => 'Цена за лида',
            'date' => 'Дата',
            'logo' => 'Иконка',
            'type' => 'Тип',
            'area' => 'Сфера оффера',
        ];
    }
}
