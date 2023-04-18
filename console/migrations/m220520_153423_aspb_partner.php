<?php

use yii\db\Migration;

/**
 * Class m220516_153423_aspb_partner
 */
class m220520_153423_aspb_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_partner}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string(255)->null()->comment('Наименование'),
            'phone' => $this->string(255)->null()->comment('Номер телефона'),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220516_153423_aspb_partner cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220516_153423_aspb_partner cannot be reverted.\n";

        return false;
    }
    */
}
