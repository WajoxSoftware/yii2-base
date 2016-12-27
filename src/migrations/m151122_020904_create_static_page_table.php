<?php
use yii\db\Schema;
use yii\db\Migration;

class m151122_020904_create_static_page_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%content_node}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NULL',
            'parent_node_id' => Schema::TYPE_INTEGER . ' NULL',
            'parent_node_ids' => Schema::TYPE_STRING . ' NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'layout' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'preview_image_id' => Schema::TYPE_INTEGER . ' NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'tags' => Schema::TYPE_STRING . ' NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('url', '{{%content_node}}', 'url', true);

        $this->addForeignKey("FK_content_node_user_id", "{{%content_node}}", "user_id", "{{%user}}", "id", 'SET NULL');
        //$this->addForeignKey("FK_content_node_parent_id", "{{%content_node}}", "parent_node_id", "{{%content_node}}", "id", 'CASCADE');
        $this->addForeignKey("FK_content_node_image_id", "{{%content_node}}", "preview_image_id", "{{%uploaded_file}}", "id", 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('{{%content_node}}');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
