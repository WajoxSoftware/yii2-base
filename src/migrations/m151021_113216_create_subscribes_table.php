<?php
use yii\db\Schema;
use yii\db\Migration;

class m151021_113216_create_subscribes_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%subscribe}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NULL',
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'email_list_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NULL',
            'phone' => Schema::TYPE_STRING . ' NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('guid', '{{%subscribe}}', 'guid');

        $this->addForeignKey("FK_subscribe_user_id", "{{%subscribe}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_subscribe_list_id", "{{%subscribe}}", "email_list_id", "{{%email_list}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%subscribe}}');

        return true;
    }
}
