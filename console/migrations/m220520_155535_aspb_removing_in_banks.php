<?php

use yii\db\Migration;

/**
 * Class m220520_155535_aspb_removing_in_banks
 */
class m220520_155535_aspb_removing_in_banks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_removing_in_banks}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'client_id' => $this->integer()->notNull()->comment('ID клиента'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'ay' => $this->integer()->null()->comment('АУ'),
            'number_affairs' => $this->text()->null()->comment('Номер дела'),
            'partner' => $this->string(255)->null()->comment('Партнёр'),
            'status_affairs' => "ENUM('Не признан', 'Признан', 'Завершено', 'Прекращено') NULL",
            'withdrawal_order' => "ENUM('Да', 'Нет') NULL",
            'date_order_sent' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата отправки распоряжения'),
            'sz_date_upon_completion' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата СЗ по завершению'),
            'banks' => $this->text()->null()->comment('Банки (счета для снятий)'),
            'requisites' => $this->text()->null()->comment('Реквизиты для ПМ (счета третьих лиц)'),
            'compound' => $this->text()->null()->comment('Состав ПМ'),
            'pm_region_rf' => $this->integer()->defaultValue(0)->comment('ПМ по региону или РФ'),
            'incomes' => $this->text()->null()->comment('Доходы (Вид дохода - сумма)'),
            'bankruptcy_estate_distributed' => $this->text()->null()->comment('Конкурсная масса распределена'),
            'rest_debtor' => $this->integer()->null()->comment('Остаток'),
            'rest_transferred_debtor' => $this->text()->null()->comment('Остаток переведен Должнику'),
            'debt' => $this->integer()->null()->comment('Долг (из своих)'),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220520_155535_aspb_removing_in_banks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220520_155535_aspb_removing_in_banks cannot be reverted.\n";

        return false;
    }
    */
}
