<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dev_services".
 *
 * @property int $id ID
 * @property string $image Картинка
 * @property string $title Название услуги
 * @property string $subtitle Подзаголовок услуги
 */
class DevServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dev_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'title', 'subtitle'], 'required'],
            [['image', 'title'], 'string', 'max' => 255],
            [['subtitle'], 'string', 'max' => 511],
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
            'title' => 'Название услуги',
            'subtitle' => 'Подзаголовок услуги',
        ];
    }
}
