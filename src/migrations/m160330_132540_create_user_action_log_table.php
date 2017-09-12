<?php
use yii\db\Migration;
use yii\db\Schema;

class m160330_132540_create_user_action_log_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%log_param}}', [
            'id' => $this->primaryKey(),
            'log_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'param_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'int_value' => Schema::TYPE_INTEGER . ' NULL',
            'string_value' => Schema::TYPE_STRING. ' NULL',
        ]);

        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . ' NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'request_uri' => Schema::TYPE_STRING . ' NOT NULL',
            'referal_user_id' => Schema::TYPE_INTEGER . '  NULL',
            'referer_uri' => Schema::TYPE_STRING. ' NULL',
            'referer_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'cookie_id' => Schema::TYPE_STRING . ' NULL',
            'ip_address' => Schema::TYPE_STRING . ' NOT NULL',
            'country' => Schema::TYPE_STRING . ' NULL',
            'region' => Schema::TYPE_STRING . ' NULL',
            'city' => Schema::TYPE_STRING . ' NULL',
        ]);

        $this->createIndex('param_id', '{{%log_param}}', 'param_id');
        $this->createIndex('guid', '{{%log}}', 'guid');
        $this->createIndex('type_id', '{{%log}}', 'type_id');

        $this->addForeignKey("FK_log_param_log_id", "{{%log_param}}", "log_id", "{{%log}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%log}}');
        $this->dropTable('{{%log_param}}');
    }
}
