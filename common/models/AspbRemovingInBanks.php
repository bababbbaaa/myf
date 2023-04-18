<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_removing_in_banks".
 *
 * @property int $id ID
 * @property int $client_id ID клиента
 * @property string|null $fio ФИО
 * @property int|null $ay АУ
 * @property string|null $number_affairs Номер дела
 * @property string|null $partner Партнёр
 * @property string|null $status_affairs
 * @property string|null $withdrawal_order
 * @property string|null $date_order_sent Дата отправки распоряжения
 * @property string|null $sz_date_upon_completion Дата СЗ по завершению
 * @property string|null $banks Банки (счета для снятий)
 * @property string|null $requisites Реквизиты для ПМ (счета третьих лиц)
 * @property string|null $compound Состав ПМ
 * @property int|null $pm_region_rf ПМ по региону или РФ
 * @property string|null $incomes Доходы (Вид дохода - сумма)
 * @property string|null $bankruptcy_estate_distributed Конкурсная масса распределена
 * @property int|null $rest_debtor Остаток
 * @property string|null $rest_transferred_debtor Остаток переведен Должнику
 * @property int|null $debt Долг (из своих)
 * @property string|null $date Дата добавления
 */
class AspbRemovingInBanks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_removing_in_banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'ay', 'pm_region_rf', 'rest_debtor', 'debt'], 'integer'],
            [['number_affairs', 'status_affairs', 'withdrawal_order', 'banks', 'requisites', 'compound', 'incomes', 'bankruptcy_estate_distributed', 'rest_transferred_debtor'], 'string'],
            [['date_order_sent', 'sz_date_upon_completion', 'date'], 'safe'],
            [['fio', 'partner'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'ID клиента',
            'fio' => 'ФИО',
            'ay' => 'АУ',
            'number_affairs' => 'Номер дела',
            'partner' => 'Партнёр',
            'status_affairs' => 'Status Affairs',
            'withdrawal_order' => 'Withdrawal Order',
            'date_order_sent' => 'Дата отправки распоряжения',
            'sz_date_upon_completion' => 'Дата СЗ по завершению',
            'banks' => 'Банки (счета для снятий)',
            'requisites' => 'Реквизиты для ПМ (счета третьих лиц)',
            'compound' => 'Состав ПМ',
            'pm_region_rf' => 'ПМ по региону или РФ',
            'incomes' => 'Доходы (Вид дохода - сумма)',
            'bankruptcy_estate_distributed' => 'Конкурсная масса распределена',
            'rest_debtor' => 'Остаток',
            'rest_transferred_debtor' => 'Остаток переведен Должнику',
            'debt' => 'Долг (из своих)',
            'date' => 'Дата добавления',
        ];
    }
}
