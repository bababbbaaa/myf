<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cases".
 *
 * @property int $id
 * @property string $link
 * @property string $name
 * @property string $type
 * @property string $logo
 * @property string $boss_img
 * @property string $small_description
 * @property string|null $input
 * @property string|null $result
 * @property string|null $from_to
 * @property string|null $comment
 * @property string|null $boss_name
 * @property string|null $boss_op
 * @property string $big_description
 * @property string $date
 * @property int $active
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $og_image
 * @property string|null $og_title
 * @property string|null $og_description
 */
class Cases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'name', 'type', 'logo', 'boss_img', 'small_description', 'big_description'], 'required'],
            [['input', 'result', 'from_to', 'comment', 'big_description'], 'string'],
            [['date'], 'safe'],
            [['active'], 'integer'],
            [['link', 'name', 'type', 'logo', 'boss_img', 'small_description', 'boss_name', 'boss_op', 'meta_description', 'meta_keywords', 'og_image', 'og_title', 'og_description'], 'string', 'max' => 255],
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
            'link' => 'Ссылка',
            'name' => 'Организация',
            'type' => 'Тип работ',
            'logo' => 'Логотип',
            'boss_img' => 'Фото представителя',
            'small_description' => 'Малое описание',
            'input' => 'Начальные данные',
            'result' => 'Результат',
            'from_to' => 'Было - Стало',
            'comment' => 'Комментарий',
            'boss_name' => 'Имя представителя',
            'boss_op' => 'Должность представителя',
            'big_description' => 'Большое описание',
            'date' => 'Дата',
            'active' => 'Активность',
            'meta_description' => 'МЕТА описание',
            'meta_keywords' => 'МЕТА ключи',
            'og_image' => 'OG-картинка',
            'og_title' => 'OG-заголовок',
            'og_description' => 'OG-описание',
        ];
    }
}
