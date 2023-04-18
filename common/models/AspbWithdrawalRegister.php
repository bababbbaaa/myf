<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspb_withdrawal_register".
 *
 * @property int $id ID
 * @property int $id_removing ID снятия
 * @property string|null $fio ФИО
 * @property string|null $withdrawal_date Дата снятия
 * @property int|null $withdrawal_summ Сумма снятия
 * @property int|null $pm_debtor ПМ должнику
 * @property int|null $from_their Из своих
 * @property int|null $rest_km_withdrawal Остаток в КМ со снятия
 * @property string|null $transfer_status
 * @property string|null $requisites Реквизиты для ПМ (счета третьих лиц)
 * @property string|null $partner Партнёр
 * @property string|null $date_transfer Дата перевода
 * @property string|null $banks Банки (счета для снятий)
 * @property string|null $comments Комментарий
 * @property string|null $withdrawal_status
 */
class AspbWithdrawalRegister extends \yii\db\ActiveRecord
{
    const   STATUS_CONFIRMED    = 'Согласован',
            STATUS_AGREEMENT    = 'На согласовании у АУ',
            STATUS_TRANSFERRED  = 'Переведено',
            STATUS_PROBLEM      = 'Проблема';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspb_withdrawal_register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_removing'], 'required'],
            [['id_removing', 'withdrawal_summ', 'pm_debtor', 'from_their', 'rest_km_withdrawal'], 'integer'],
            [['withdrawal_date', 'date_transfer'], 'safe'],
            [['transfer_status', 'requisites', 'banks', 'comments', 'withdrawal_status'], 'string'],
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
            'id_removing' => 'ID снятия',
            'fio' => 'ФИО',
            'withdrawal_date' => 'Дата снятия',
            'withdrawal_summ' => 'Сумма снятия',
            'pm_debtor' => 'ПМ должнику',
            'from_their' => 'Из своих',
            'rest_km_withdrawal' => 'Остаток в КМ со снятия',
            'transfer_status' => 'Transfer Status',
            'requisites' => 'Реквизиты для ПМ (счета третьих лиц)',
            'partner' => 'Партнёр',
            'date_transfer' => 'Дата перевода',
            'banks' => 'Банки (счета для снятий)',
            'comments' => 'Комментарий',
            'withdrawal_status' => 'Withdrawal Status',
        ];
    }
}
