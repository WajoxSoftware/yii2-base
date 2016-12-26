<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_020001_create_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'account_balance' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'referal_user_id' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'ip_address' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
            'role' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'user\'',
            'email' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'confirmed_email' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'confirmed_at' => Schema::TYPE_INTEGER . ' NOT NULL  DEFAULT \'0\'',
            'confirmation_token' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'auth_key' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'password_reset_token' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'avatar_file_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'first_name' => Schema::TYPE_STRING . ' NULL',
            'last_name' => Schema::TYPE_STRING . ' NULL',
            'gender' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'phone' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'\'',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'birthdate' => Schema::TYPE_DATE . ' NOT NULL DEFAULT \'1990-01-01\'',
            'display_in_search' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'1\'',
            'last_login_at' => Schema::TYPE_INTEGER . ' NULL',
        ], $tableOptions);

        $this->createIndex('guid', '{{%user}}', 'guid', true);
        $this->createIndex('email', '{{%user}}', 'email', true);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');

        return true;
    }
}
