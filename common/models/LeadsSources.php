<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_sources".
 *
 * @property int $id
 * @property string $name
 * @property int $cc
 * @property string $date
 * @property string $sendpulse_book
 */
class LeadsSources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_sources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date'], 'safe'],
            [['cc'], 'integer'],
            [['name', 'sendpulse_book'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Источник',
            'date' => 'Дата',
            'cc' => 'Источник для КЦ',
            'sendpulse_book' => 'Книга в сендпульс',
        ];
    }
}
