<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m3_projects".
 *
 * @property int $id ID
 * @property string|null $date_start Дата начала
 * @property string|null $date_end Дата окончания
 * @property string $name Название
 * @property string $source Источник
 * @property string $responsible Источник
 * @property string|null $specs_link Ссылка на ТЗ
 * @property float $price Цена проекта
 * @property string $status Статус проекта
 * @property float $costs Расходы
 * @property int $money_got Деньги выплачены
 * @property int $money_paid Деньги выплачены
 * @property string $payment_type Способ оплаты
 */
class M3Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end'], 'safe'],
            [['name', 'source', 'price'], 'required'],
            [['price', 'costs', 'money_paid'], 'number'],
            [['money_got'], 'integer'],
            [['costs', 'money_paid'], 'default', 'value' => 0],
            [['name', 'source', 'status', 'responsible', 'payment_type'], 'string', 'max' => 255],
            [['specs_link'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'name' => 'Название',
            'source' => 'Источник',
            'specs_link' => 'Ссылка на ТЗ',
            'price' => 'Цена проекта',
            'status' => 'Статус проекта',
            'costs' => 'Расходы',
            'responsible' => 'Исполнитель',
            'money_got' => 'Деньги выплачены',
            'money_paid' => 'Денег получено от заказчика',
            'payment_type' => 'Способ оплаты',
        ];
    }
}
