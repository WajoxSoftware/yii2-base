<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020027_create_user_network_account extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_network_account}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'provider' => Schema::TYPE_STRING . ' NOT NULL',
            'uid' => Schema::TYPE_STRING . ' NOT NULL',
            'params' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_user_net_account_user_id", "{{%user_network_account}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_network_account}}');

        return true;
    }
}
