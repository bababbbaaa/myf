<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_backdoor".
 *
 * @property int $id
 * @property string $source
 * @property string|null $name
 * @property string $phone
 * @property string|null $region
 * @property string|null $email
 * @property string|null $comments
 * @property string $date
 * @property string $log
 */
class LeadsBackdoor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_backdoor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'phone'], 'required'],
            [['comments', 'log'], 'string'],
            [['date'], 'safe'],
            [['source', 'name', 'phone', 'region', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Источник',
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'region' => 'Регион',
            'email' => 'Email',
            'comments' => 'Комментарии',
            'date' => 'Дата',
            'log' => 'Лог',
        ];
    }
}
