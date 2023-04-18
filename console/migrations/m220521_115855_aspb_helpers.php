<?php

use yii\db\Migration;

/**
 * Class m220520_115855_aspb_helpers
 */
class m220521_115855_aspb_helpers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_helpers}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'phone' => $this->string(255)->null()->comment('Телефон'),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220520_115855_aspb_helpers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220520_115855_aspb_helpers cannot be reverted.\n";

        return false;
    }
    */
}
