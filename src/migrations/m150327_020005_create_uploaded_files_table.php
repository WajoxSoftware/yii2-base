<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020005_create_uploaded_files_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%uploaded_file}}', [
            'id' => Schema::TYPE_PK,
            'file' => Schema::TYPE_STRING . ' NOT NULL',
            'size' => Schema::TYPE_BIGINT . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        //$this->addForeignKey("FK_uploaded_file_user_id", "{{%uploaded_file}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%uploaded_file}}');

        return true;
    }
}
