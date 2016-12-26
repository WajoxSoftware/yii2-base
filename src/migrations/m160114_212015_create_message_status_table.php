<?php

use yii\db\Migration;
use yii\db\Schema;

class m160114_212015_create_message_status_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%message_user_status}}', [
            'id' => Schema::TYPE_PK,
            'dialog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'message_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_user_msgstatus_dialog_id", "{{%message_user_status}}", "dialog_id", "{{%dialog}}", "id", 'CASCADE');
        $this->addForeignKey("FK_user_msgstatus_user_user_id", "{{%message_user_status}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_user_msgstatus_user_message_id", "{{%message_user_status}}", "message_id", "{{%message}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%message_user_status}}');

        return true;
    }
}
