<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cdb_allowed_articles".
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $date
 */
class CdbAllowedArticles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdb_allowed_articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id'], 'required'],
            [['user_id', 'article_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'date' => 'Date',
        ];
    }
}
