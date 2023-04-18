<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "technologies".
 *
 * @property int $id
 * @property int $is_active
 * @property string $name
 * @property string $category
 * @property string $preview
 * @property string $subtitle
 * @property string $popup_data
 * @property string $date
 * @property string $essence
 * @property string|null $first_image
 * @property string|null $second_image
 * @property float $price
 * @property string|null $important
 * @property string $advantage
 */
class Technologies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technologies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'preview', 'subtitle', 'popup_data', 'price', 'first_section_advantage', 'essence'], 'required'],
            [['popup_data', 'first_section_advantage', 'second_section_advantage', 'essence', 'important'], 'string'],
            [['is_active', 'price'], 'integer'],
            [['date'], 'safe'],
            [['name', 'preview', 'subtitle', 'category', 'first_image', 'second_image'], 'string', 'max' => 255],
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
            'category' => 'Категория',
            'is_active' => 'Технология активна',
            'preview' => 'Превью текст',
            'subtitle' => 'Подзаголовок',
            'popup_data' => 'Данные рендера',
            'date' => 'Дата',
            'essence' => 'Суть технологии',
            'first_image' => 'Первая иллюстрация',
            'second_image' => 'Вторая иллюстрация',
            'price' => 'Цена технологии',
            'important' => 'Важно (Не обязательное поле)',
            'first_section_advantage' => 'Преимущества первая секция',
            'second_section_advantage' => 'Преимущества вторая секция',
        ];
    }
}
