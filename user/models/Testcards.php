<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testcards".
 *
 * @property int $id ID
 * @property string $title Заголовок
 * @property string $text Текст
 * @property string $date Дата
 */
class Testcards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testcards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'date' => 'Дата',
        ];
    }
}
