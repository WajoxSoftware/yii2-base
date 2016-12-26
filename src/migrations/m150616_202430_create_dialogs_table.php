<?php

use yii\db\Migration;
use yii\db\Schema;

class m150616_202430_create_dialogs_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%dialog}}', [
            'id' => $this->primaryKey(),
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_dialog_user_id", "{{%dialog}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%dialog}}');
    }
}
