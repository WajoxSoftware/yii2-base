<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020031_CreateCustomersTable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%customer}}', [
            'id' => Schema::TYPE_PK,
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'uniqid' => Schema::TYPE_STRING . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'referal_user_id' => Schema::TYPE_INTEGER . ' NULL',
            'full_name' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'phone' => Schema::TYPE_STRING . ' NOT NULL',
            'postalcode' => Schema::TYPE_STRING,
            'country' => Schema::TYPE_STRING,
            'region' => Schema::TYPE_STRING,
            'city' => Schema::TYPE_STRING,
            'address' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
        ], $tableOptions);

        $this->createIndex('guid', '{{%customer}}', 'guid');
        $this->createIndex('uniqid', '{{%customer}}', 'uniqid', true);

        $this->addForeignKey("FK_customer_user_id", "{{%customer}}", "user_id", "{{%user}}", "id", 'NO ACTION');
        $this->addForeignKey("FK_customer_referal_user_id", "{{%customer}}", "referal_user_id", "{{%user}}", "id", 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('{{%customer}}');

        return true;
    }
}
