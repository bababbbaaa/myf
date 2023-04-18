<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "deals_backdoor".
 *
 * @property int $id
 * @property string $source
 * @property string|null $name
 * @property string $phone
 * @property string $region
 * @property string $email
 * @property string $comments
 * @property string $date
 * @property string $log
 * @property string $date_start
 * @property float $summ
 */
class DealsBackdoor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deals_backdoor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'phone'], 'required'],
            [['comments', 'log'], 'string'],
            [['date', 'date_start'], 'safe'],
            [['summ'], 'number'],
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
            'source' => 'Source',
            'name' => 'Name',
            'phone' => 'Phone',
            'region' => 'Region',
            'email' => 'Email',
            'comments' => 'Comments',
            'date' => 'Date',
            'log' => 'Log',
            'date_start' => 'Date Start',
            'summ' => 'Summ',
        ];
    }
}
