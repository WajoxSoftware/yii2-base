<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020032_create_bills_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%bill}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'customer_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'sum' => Schema::TYPE_DECIMAL . ' NOT NULL',
            'payment_method' => Schema::TYPE_STRING . ' NOT NULL',
            'payment_destination_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_bill_user_id", "{{%bill}}", "user_id", "{{%user}}", "id", 'NO ACTION');
        $this->addForeignKey("FK_bill_customer_id", "{{%bill}}", "customer_id", "{{%customer}}", "id", 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%bill}}');

        return true;
    }
}
