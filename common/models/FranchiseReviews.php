<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "franchise_reviews".
 *
 * @property int $id
 * @property int $franchise_id
 * @property int $rating
 * @property string $date
 * @property string $author
 * @property string $content
 * @property int $is_active
 */
class FranchiseReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franchise_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['franchise_id', 'author', 'content'], 'required'],
            [['franchise_id', 'rating', 'is_active'], 'integer'],
            [['date'], 'safe'],
            [['content'], 'string'],
            [['author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'franchise_id' => 'Франшиза',
            'rating' => 'Рейтинг отзыва',
            'date' => 'Дата',
            'author' => 'Автор',
            'content' => 'Содержание',
            'is_active' => 'Активность',
        ];
    }
}
