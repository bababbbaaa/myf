<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "cookie_validator".
 *
 * @property int $id
 * @property string $hash
 * @property string $date_current
 * @property string|null $date_prev
 */
class CookieValidator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cookie_validator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash', 'date_current'], 'required'],
            [['hash', 'date_current', 'date_prev'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'date_current' => 'Date Current',
            'date_prev' => 'Date Prev',
        ];
    }
}
