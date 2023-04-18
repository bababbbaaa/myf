<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ads_orders".
 *
 * @property int $id ID
 * @property string $title Название заказа
 * @property string $specialization Специализация
 * @property string $platform Площадка
 * @property string $description Описание заказа
 * @property string|null $file Дополнительный файл
 * @property string|null $date_end Зата завершения
 * @property int|null $budjet Бюджет заказа
 * @property int $client_id ID заказчика
 * @property int|null $performers_id ID исполнителя
 * @property string $status Статус заказа
 * @property string $date Дата публикации
 */
class AdsOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'specialization', 'platform', 'description', 'client_id', 'status'], 'required'],
            [['description', 'status'], 'string'],
            [['date_end', 'date'], 'safe'],
            [['budjet', 'client_id', 'performers_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['file'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название заказа',
            'specialization' => 'Специализация',
            'platform' => 'Площадка',
            'description' => 'Описание заказа',
            'file' => 'Дополнительный файл',
            'date_end' => 'Зата завершения',
            'budjet' => 'Бюджет заказа',
            'client_id' => 'ID заказчика',
            'performers_id' => 'ID исполнителя',
            'status' => 'Статус заказа',
            'date' => 'Дата публикации',
        ];
    }
}
