<?php

use yii\db\Migration;
use yii\db\Schema;

class m160330_132540_create_user_action_log_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_action_log}}', [
            'id' => $this->primaryKey(),
            'action_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'action_item_id' => Schema::TYPE_INTEGER . ' NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'request_uri' => Schema::TYPE_STRING . ' NOT NULL',
            'referal_user_id' => Schema::TYPE_INTEGER . '  NULL',
            'referer_uri' => Schema::TYPE_STRING. ' NULL',
            'referer_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_subaccount_id' => Schema::TYPE_INTEGER . ' NULL',
            'traffic_stream_id' => Schema::TYPE_INTEGER . ' NULL',
            'cookie_id' => Schema::TYPE_STRING . ' NULL',
            'offer_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'offer_item_id' => Schema::TYPE_INTEGER . ' NULL',
            'ip_address' => Schema::TYPE_STRING . ' NOT NULL',
            'country' => Schema::TYPE_STRING . ' NULL',
            'region' => Schema::TYPE_STRING . ' NULL',
            'city' => Schema::TYPE_STRING . ' NULL',
        ]);

        $this->createIndex('action_type_id', '{{%user_action_log}}', 'action_type_id');
        $this->createIndex('action_item_id', '{{%user_action_log}}', 'action_item_id');
        $this->createIndex('guid', '{{%user_action_log}}', 'guid');
    }

    public function down()
    {
        $this->dropTable('{{%user_action_log}}');
    }
}
