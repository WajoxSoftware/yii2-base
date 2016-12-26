<?php
use yii\db\Schema;
use yii\db\Migration;

class m150327_020003_create_email_list_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%email_list}}', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
            'api_id' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('url', '{{%email_list}}', 'url', true);
        $this->createIndex('api_id', '{{%email_list}}', 'api_id', true);
    }

    public function down()
    {
        $this->dropTable('{{%email_list}}');

        return true;
    }
}
