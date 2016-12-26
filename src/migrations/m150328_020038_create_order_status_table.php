<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020038_create_order_status_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_status}}', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delivery_status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT . ' NULL',
            'uploaded_file_id' => Schema::TYPE_INTEGER . ' NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_order_status_order_id", "{{%order_status}}", "order_id", "{{%order}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%order_status}}');

        return true;
    }
}
