<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_info".
 *
 * @property int $id ID
 * @property string|null $fio ФИО
 * @property string|null $date_create Дата приема дела
 * @property string|null $date_send_sro Дата отправки в СРО
 * @property int|null $ay АУ
 * @property string|null $number_affairs Номер дела
 * @property string|null $partner Партнёр
 * @property string|null $date_session Дата судебного заседания по признанию
 * @property string|null $status_affairs
 * @property string|null $proc
 * @property string|null $date_send_sro_confirm Дата отправки согласия СРО
 * @property string|null $document
 * @property int|null $complexity_case Сложность дела
 * @property int|null $income Доход
 * @property int|null $property_in_sale Имущество в реализацию
 * @property int|null $transactions_for_contesting Сделки под оспаривание
 * @property int|null $active_creditors Активные кредиторы
 * @property string|null $additional_documents Запрос на дополнительные документы
 * @property int|null $deposit Депозит из Суда
 * @property string|null $deposit_receipt Дата получения депозита
 * @property int|null $additional_deposit Дополнительный депозит в суде
 * @property string|null $additional_deposit_date Дополнительный депозит получен
 * @property int|null $mandatory_payments_pay Размер обязательных платежей к оплате
 * @property int|null $mandatory_payments_paid Размер обязательных платежей оплаченных
 * @property int|null $additional_payments_pay Размер дополнительных платежей к оплате
 * @property int|null $additional_payments_paid Размер дополнительных платежей оплаченных
 * @property int|null $expenses_kommersant Расходы Коммерсант
 * @property int|null $expenses_efrsb Расходы ЕФРСБ
 * @property int|null $expenses_pochta Расходы Почта
 * @property int|null $expenses_helpers Расходы Помощники
 * @property string|null $efrsb ЕФРСБ
 * @property string|null $responsible_primary_work Ответственный за Первичную работу
 * @property string|null $kommersant Коммерсант
 * @property string|null $kommersant_paid Коммерсант оплата
 * @property string|null $request_to_debtor Отправка запроса должнику
 * @property string|null $sending_to_government_agencies Отправка в госорганы
 * @property string|null $order_usrn Заказ ЕГРН
 * @property string|null $sending_creditors Отправка кредиторам
 * @property string|null $status_affairs_aspb
 * @property int|null $additional_deposit_confirm Дополнительный депозит получен
 * @property string|null $inventory_of_property Опись имущества и отметка о выполнении
 * @property string|null $deliberate_fictitious Преднамеренное фиктивное и отметка о выполнении
 * @property string|null $assembly_of_creditors Собрание кредиторов
 * @property string|null $sz_date_upon_completion Дата СЗ по завершению
 * @property string|null $directed_to_sz
 * @property string|null $verified_sent_sz
 * @property string|null $responsible_assistant Ответственный помощник
 * @property string|null $comment_case Комментарий к делу
 */
class AspbInfo extends \yii\db\ActiveRecord
{

    const   STATUS_CONFIRM = 'Признан',
            STATUS_NOT_CONFIRM = 'Не признан',
            STATUS_DONE = 'Завершено',
            STATUS_CROSSED = 'Прекращено';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_send_sro', 'date_session', 'date_send_sro_confirm', 'deposit_receipt', 'additional_deposit_date', 'efrsb', 'kommersant', 'request_to_debtor', 'order_usrn', 'sz_date_upon_completion'], 'safe'],
            [['ay', 'complexity_case', 'income', 'property_in_sale', 'transactions_for_contesting', 'active_creditors', 'deposit', 'additional_deposit', 'mandatory_payments_pay', 'mandatory_payments_paid', 'additional_payments_pay', 'additional_payments_paid', 'expenses_kommersant', 'expenses_efrsb', 'expenses_pochta', 'expenses_helpers', 'additional_deposit_confirm'], 'integer'],
            [['number_affairs', 'status_affairs', 'proc', 'document', 'sending_to_government_agencies', 'sending_creditors', 'status_affairs_aspb', 'directed_to_sz', 'verified_sent_sz', 'comment_case'], 'string'],
            [['fio', 'partner'], 'string', 'max' => 255],
            [['additional_documents', 'responsible_primary_work', 'kommersant_paid', 'inventory_of_property', 'deliberate_fictitious', 'assembly_of_creditors', 'responsible_assistant'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'date_create' => 'Дата приема дела',
            'date_send_sro' => 'Дата отправки в СРО',
            'ay' => 'АУ',
            'number_affairs' => 'Номер дела',
            'partner' => 'Партнёр',
            'date_session' => 'Дата судебного заседания по признанию',
            'status_affairs' => 'Status Affairs',
            'proc' => 'Proc',
            'date_send_sro_confirm' => 'Дата отправки согласия СРО',
            'document' => 'Document',
            'complexity_case' => 'Сложность дела',
            'income' => 'Доход',
            'property_in_sale' => 'Имущество в реализацию',
            'transactions_for_contesting' => 'Сделки под оспаривание',
            'active_creditors' => 'Активные кредиторы',
            'additional_documents' => 'Запрос на дополнительные документы',
            'deposit' => 'Депозит из Суда',
            'deposit_receipt' => 'Дата получения депозита',
            'additional_deposit' => 'Дополнительный депозит в суде',
            'additional_deposit_date' => 'Дополнительный депозит получен',
            'mandatory_payments_pay' => 'Размер обязательных платежей к оплате',
            'mandatory_payments_paid' => 'Размер обязательных платежей оплаченных',
            'additional_payments_pay' => 'Размер дополнительных платежей к оплате',
            'additional_payments_paid' => 'Размер дополнительных платежей оплаченных',
            'expenses_kommersant' => 'Расходы Коммерсант',
            'expenses_efrsb' => 'Расходы ЕФРСБ',
            'expenses_pochta' => 'Расходы Почта',
            'expenses_helpers' => 'Расходы Помощники',
            'efrsb' => 'ЕФРСБ',
            'responsible_primary_work' => 'Ответственный за Первичную работу',
            'kommersant' => 'Коммерсант',
            'kommersant_paid' => 'Коммерсант оплата',
            'request_to_debtor' => 'Отправка запроса должнику',
            'sending_to_government_agencies' => 'Отправка в госорганы',
            'order_usrn' => 'Заказ ЕГРН',
            'sending_creditors' => 'Отправка кредиторам',
            'status_affairs_aspb' => 'Status Affairs Aspb',
            'additional_deposit_confirm' => 'Дополнительный депозит получен',
            'inventory_of_property' => 'Опись имущества и отметка о выполнении',
            'deliberate_fictitious' => 'Преднамеренное фиктивное и отметка о выполнении',
            'assembly_of_creditors' => 'Собрание кредиторов',
            'sz_date_upon_completion' => 'Дата СЗ по завершению',
            'directed_to_sz' => 'Directed To Sz',
            'verified_sent_sz' => 'Verified Sent Sz',
            'responsible_assistant' => 'Ответственный помощник',
            'comment_case' => 'Комментарий к делу',
        ];
    }
}
