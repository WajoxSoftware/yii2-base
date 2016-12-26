<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_202443_create_messages_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%message}}', [
            'id' => Schema::TYPE_PK,
            'dialog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_message_dialog_id", "{{%message}}", "dialog_id", "{{%dialog}}", "id", 'CASCADE');
        $this->addForeignKey("FK_message_user_id", "{{%message}}", "dialog_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%message}}');

        return true;
    }
}
