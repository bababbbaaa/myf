<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dev_payments_alias".
 *
 * @property int $id ID
 * @property int $user_id ID пользователя
 * @property int $project_id ID проекта
 * @property int $summ Сумма оплаты
 * @property string $status Статус оплаты
 * @property string $when_pay Время оплаты
 * @property string|null $date_pay Дата оплаты
 */
class DevPaymentsAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dev_payments_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'summ', 'when_pay'], 'required'],
            [['user_id', 'project_id', 'summ'], 'integer'],
            [['status'], 'string'],
            [['when_pay', 'date_pay'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'project_id' => 'ID проекта',
            'summ' => 'Сумма оплаты',
            'status' => 'Статус оплаты',
            'when_pay' => 'Время оплаты',
            'date_pay' => 'Дата оплаты',
        ];
    }
}
