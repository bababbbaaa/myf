<?php

use yii\db\Migration;

/**
 * Class m220518_103340_aspb_responsible
 */
class m220520_103340_aspb_responsible extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aspb_responsible}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'fio' => $this->string(255)->null()->comment('ФИО'),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->null()->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220518_103340_aspb_responsible cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220518_103340_aspb_responsible cannot be reverted.\n";

        return false;
    }
    */
}
