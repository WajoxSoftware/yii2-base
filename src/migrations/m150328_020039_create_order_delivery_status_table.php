<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020039_create_order_delivery_status_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_delivery_status}}', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_order_dstatus_order_id", "{{%order_status}}", "order_id", "{{%order}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%order_delivery_status}}');

        return true;
    }
}
