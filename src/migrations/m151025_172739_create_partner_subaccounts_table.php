<?php
use yii\db\Schema;
use yii\db\Migration;

class m151025_172739_create_partner_subaccounts_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_subaccount}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'tag1' => Schema::TYPE_STRING . ' NOT NULL',
            'tag2' => Schema::TYPE_STRING . ' NULL',
            'tag3' => Schema::TYPE_STRING . ' NULL',
            'tag4' => Schema::TYPE_STRING . ' NULL',
        ], $tableOptions);

        $this->createIndex('tag', '{{%user_subaccount}}', ['user_id', 'tag1', 'tag2', 'tag3', 'tag4'], true);
        $this->createIndex('tag1', '{{%user_subaccount}}', 'tag1');
        $this->createIndex('tag2', '{{%user_subaccount}}', 'tag2');
        $this->createIndex('tag3', '{{%user_subaccount}}', 'tag3');
        $this->createIndex('tag4', '{{%user_subaccount}}', 'tag4');

        $this->addForeignKey("FK_user_subaccount_user_id", "{{%user_subaccount}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_subaccount}}');

        return true;
    }
}
