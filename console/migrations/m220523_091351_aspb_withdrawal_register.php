<?php

use yii\db\Migration;

/**
 * Class m220523_091351_aspb_withdrawal_register
 */
class m220523_091351_aspb_withdrawal_register extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_withdrawal_register}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'id_removing' => $this->integer()->notNull()->comment('ID снятия'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'withdrawal_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата снятия'),
            'withdrawal_summ' => $this->integer()->null()->comment('Сумма снятия'),
            'pm_debtor' => $this->integer()->null()->comment('ПМ должнику'),
            'from_their' => $this->integer()->null()->comment('Из своих'),
            'rest_km_withdrawal' => $this->integer()->null()->comment('Остаток в КМ со снятия'),
            'transfer_status' => "ENUM('Не указан', 'На согласовании у АУ', 'Переведено', 'Проблема') NULL",
            'requisites' => $this->text()->null()->comment('Реквизиты для ПМ (счета третьих лиц)'),
            'partner' => $this->string(255)->null()->comment('Партнёр'),
            'date_transfer' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата перевода'),
            'banks' => $this->text()->null()->comment('Банки (счета для снятий)'),
            'comments' => $this->text()->null()->comment('Комментарий'),
            'withdrawal_status' => "ENUM('Пусто', 'КМ', 'Внесение', 'Наличными в кассу') NULL",

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220523_091351_aspb_withdrawal_register cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220523_091351_aspb_withdrawal_register cannot be reverted.\n";

        return false;
    }
    */
}
