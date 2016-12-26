<?php
use yii\db\Schema;
use yii\db\Migration;

class m151018_154106_created_good_payment_methods_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_payment_method}}', [
            'id' => Schema::TYPE_PK,
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'payment_method' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_good_pmethod_good_id", "{{%good_payment_method}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_payment_method}}');

        return true;
    }
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
