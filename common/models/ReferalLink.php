<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "referal_link".
 *
 * @property int $id ID
 * @property string $title Название
 * @property string $link Ссылка
 * @property string $text_advantages Преимущества
 * @property string $sub_title Описание
 * @property string $date Дата добавления
 * @property string $logo Логотип
 */
class ReferalLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referal_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link', 'text_advantages', 'sub_title', 'logo'], 'required'],
            [['text_advantages', 'sub_title'], 'string'],
            [['date'], 'safe'],
            [['title', 'link', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'link' => 'Ссылка',
            'text_advantages' => 'Преимущества',
            'sub_title' => 'Описание',
            'date' => 'Дата добавления',
            'logo' => 'Логотип',
        ];
    }
}
