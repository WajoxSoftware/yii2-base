<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020033_create_orders_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}', [
            'id' => Schema::TYPE_PK,
            'bill_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'customer_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'sum' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'delivery_sum' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'delivery_method' => Schema::TYPE_STRING . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delivery_status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delivery_status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'saler_comment' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addForeignKey("FK_order_bill_id", "{{%order}}", "bill_id", "{{%bill}}", "id", 'CASCADE');
        $this->addForeignKey("FK_order_user_id", "{{%order}}", "user_id", "{{%user}}", "id", 'NO ACTION');
        $this->addForeignKey("FK_order_customer_id", "{{%order}}", "customer_id", "{{%customer}}", "id", 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%order}}');

        return true;
    }
}
