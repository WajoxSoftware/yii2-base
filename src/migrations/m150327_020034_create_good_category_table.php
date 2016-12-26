<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020034_create_good_category_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_category}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' =>  Schema::TYPE_INTEGER . ' NULL',
            'parents_ids' =>  Schema::TYPE_STRING . ' NULL',
            'url' =>  Schema::TYPE_STRING . ' NOT NULL',
            'title' =>  Schema::TYPE_STRING . ' NOT NULL',
            'status_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('url', '{{%good_category}}', 'url', true);

        $this->addForeignKey("FK_good_cat_parent_id", "{{%good_category}}", "parent_id", "{{%good_category}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_category}}');

        return true;
    }
}
