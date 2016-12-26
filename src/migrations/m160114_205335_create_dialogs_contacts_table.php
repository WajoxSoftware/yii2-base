<?php

use yii\db\Migration;
use yii\db\Schema;

class m160114_205335_create_dialogs_contacts_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%dialog_user}}', [
            'id' => Schema::TYPE_PK,
            'dialog_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'message_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_dialog_user_dialog_id", "{{%dialog_user}}", "dialog_id", "{{%dialog}}", "id", 'CASCADE');
        $this->addForeignKey("FK_dialog_user_user_id", "{{%dialog_user}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_dialog_user_message_id", "{{%dialog_user}}", "message_id", "{{%message}}", "id", 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%dialog_user}}');

        return true;
    }
}
