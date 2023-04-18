<?php

use yii\db\Migration;

/**
 * Class m220513_095154_aspb
 */
class m220520_095154_aspb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_info}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'date_create' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->comment('Дата приема дела'),
            'date_send_sro' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата отправки в СРО'),
            'ay' => $this->integer()->null()->comment('АУ'),
            'number_affairs' => $this->text()->null()->comment('Номер дела'),
            'partner' => $this->string(255)->null()->comment('Партнёр'),
            'date_session' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата судебного заседания по признанию'),
            'status_affairs' => "ENUM('Не признан', 'Признан', 'Завершено', 'Прекращено') NULL",
            'proc' => "ENUM('Реализация', 'Реструктуризация') NULL",
            'date_send_sro_confirm' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата отправки согласия СРО'),
            'document' => "ENUM('Да', 'Нет', 'Не хватает документов') NULL",
            'complexity_case' => $this->integer()->null()->comment('Сложность дела'),
            'income' => $this->integer()->null()->defaultValue(0)->comment('Доход'),
            'property_in_sale' => $this->integer()->null()->defaultValue(0)->comment('Имущество в реализацию'),
            'transactions_for_contesting' => $this->integer()->null()->defaultValue(0)->comment('Сделки под оспаривание'),
            'active_creditors' => $this->integer()->null()->defaultValue(0)->comment('Активные кредиторы'),
            'additional_documents' => $this->string(511)->null()->comment('Запрос на дополнительные документы'),
            'deposit' => $this->integer()->null()->comment('Депозит из Суда'),
            'deposit_receipt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата получения депозита'),
            'additional_deposit' => $this->integer()->null()->comment('Дополнительный депозит в суде'),
            'additional_deposit_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дополнительный депозит получен'),
            'mandatory_payments_pay' => $this->integer()->null()->comment('Размер обязательных платежей к оплате'),
            'mandatory_payments_paid' => $this->integer()->null()->comment('Размер обязательных платежей оплаченных'),
            'additional_payments_pay' => $this->integer()->null()->comment('Размер дополнительных платежей к оплате'),
            'additional_payments_paid' => $this->integer()->null()->comment('Размер дополнительных платежей оплаченных'),
            'expenses_kommersant' => $this->integer()->null()->comment('Расходы Коммерсант'),
            'expenses_efrsb' => $this->integer()->null()->comment('Расходы ЕФРСБ'),
            'expenses_pochta' => $this->integer()->null()->comment('Расходы Почта'),
            'expenses_helpers' => $this->integer()->null()->comment('Расходы Помощники'),
            'efrsb' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('ЕФРСБ'),
            'responsible_primary_work' => $this->string(511)->null()->comment('Ответственный за Первичную работу'),
            'kommersant' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Коммерсант'),
            'kommersant_paid' => $this->string(511)->null()->comment('Коммерсант оплата'),
            'request_to_debtor' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Отправка запроса должнику'),
            'sending_to_government_agencies' => $this->text()->null()->comment('Отправка в госорганы'),
            'order_usrn' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Заказ ЕГРН'),
            'sending_creditors' => $this->text()->null()->comment('Отправка кредиторам'),
            'status_affairs_aspb' => "ENUM('Не признан', 'Признан', 'Завершено', 'Прекращено') NULL",
            'additional_deposit_confirm' => $this->integer()->null()->comment('Дополнительный депозит получен'),
            'inventory_of_property' => $this->string(511)->null()->comment('Опись имущества и отметка о выполнении'),
            'deliberate_fictitious' => $this->string(511)->null()->comment('Преднамеренное фиктивное и отметка о выполнении'),
            'assembly_of_creditors' => $this->string(511)->null()->comment('Собрание кредиторов'),
            'sz_date_upon_completion' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата СЗ по завершению'),
            'directed_to_sz' => "ENUM('Продление', 'Отложение', 'Перерыв', 'Переход в РИГ', 'План', 'Завершение') NULL",
            'verified_sent_sz' => "ENUM('Да', 'Нет', 'В работе') NULL",
            'responsible_assistant' => $this->string(511)->null()->comment('Ответственный помощник'),
            'comment_case' => $this->text()->null()->comment('Комментарий к делу')
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220513_095154_aspb cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220513_095154_aspb cannot be reverted.\n";

        return false;
    }
    */
}
