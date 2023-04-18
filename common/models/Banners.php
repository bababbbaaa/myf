<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property string|null $image
 * @property string $date
 * @property string $url
 * @property int $active
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['url'], 'required'],
            [['active'], 'integer'],
            [['title', 'text', 'image', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Картинка',
            'date' => 'Дата',
            'url' => 'Ссылка',
            'active' => 'Активность',
        ];
    }
}
