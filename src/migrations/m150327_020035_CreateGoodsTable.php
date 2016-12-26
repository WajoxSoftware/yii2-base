<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_020035_CreateGoodsTable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good}}', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . ' NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sum' => Schema::TYPE_DECIMAL . ' NOT NULL',
            'good_type_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'partner_status_id' =>  Schema::TYPE_INTEGER. ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'tags' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'description' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'content' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('url', '{{%good}}', 'url', true);

        $this->addForeignKey("FK_good_user_id", "{{%good}}", "user_id", "{{%user}}", "id", 'NO ACTION');
        $this->addForeignKey("FK_good_category_id", "{{%good}}", "category_id", "{{%good_category}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good}}');

        return true;
    }
}
