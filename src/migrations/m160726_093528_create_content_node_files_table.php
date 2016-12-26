<?php
use yii\db\Migration;
use yii\db\Schema;

class m160726_093528_create_content_node_files_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%content_node_file}}', [
            'id' => Schema::TYPE_PK,
            'content_node_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uploaded_file_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_cnodefile_node_id", "{{%content_node_file}}", "content_node_id", "{{%content_node}}", "id", 'CASCADE');
        $this->addForeignKey("FK_cnodefile_file_id", "{{%content_node_file}}", "uploaded_file_id", "{{%uploaded_file}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%content_node_file}}');

        return true;
    }
}
