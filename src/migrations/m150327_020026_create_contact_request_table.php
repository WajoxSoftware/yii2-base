<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020026_create_contact_request_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%contact_request}}', [
            'id' => $this->primaryKey(),
            'user_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'contact_user_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_contact_request_user1_id", "{{%contact_request}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_contact_request_user2_id", "{{%contact_request}}", "contact_user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%contact_request}}');
    }
}
