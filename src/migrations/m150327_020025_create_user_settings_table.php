<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020025_create_user_settings_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_settings}}', [
            'id' => $this->primaryKey(),
            'view_profile' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'search_profile' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'add_profile' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'message_profile' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'show_contacts' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'send_notifications' =>  Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user_settings}}');
    }
}
