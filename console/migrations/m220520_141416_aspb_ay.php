<?php

use yii\db\Migration;

/**
 * Class m220516_141416_aspb_ay
 */
class m220520_141416_aspb_ay extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_ay}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'reg_number' => $this->string(255)->null()->comment('Регистрационный номер'),
            'address' => $this->string(511)->null()->comment('Почтовый адресс'),
            'email' => $this->string(255)->null()->comment('Email'),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220516_141416_aspb_ay cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220516_141416_aspb_ay cannot be reverted.\n";

        return false;
    }
    */
}
