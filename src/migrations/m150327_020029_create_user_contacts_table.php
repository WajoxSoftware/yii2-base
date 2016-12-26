<?php
use yii\db\Schema;
use yii\db\Migration;

class m150327_020029_create_user_contacts_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_contact}}', [
            'id' => $this->primaryKey(),
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'contact_user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_user_contact_user1_id", "{{%user_contact}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_user_contact_user2_id", "{{%user_contact}}", "contact_user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_contact}}');
    }
}
