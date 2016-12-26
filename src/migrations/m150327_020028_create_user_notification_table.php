<?php

use yii\db\Migration;
use yii\db\Schema;

class m150327_020028_create_user_notification_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_notification}}', [
            'id' => $this->primaryKey(),
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_notification_user_id", "{{%user_notification}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_notification}}');
    }
}
