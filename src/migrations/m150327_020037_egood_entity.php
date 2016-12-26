<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020037_egood_entity extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%egood_entity}}', [
            'id' => Schema::TYPE_PK,
            'good_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'file_id' => Schema::TYPE_INTEGER . ' NULL',
            'file_url' =>  Schema::TYPE_STRING . ' NULL',
            'title' =>  Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NULL',
            'content' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addForeignKey("FK_egood_entity_good_id", "{{%egood_entity}}", "good_id", "{{%good}}", "id", 'CASCADE');
        $this->addForeignKey("FK_egood_entity_file_id", "{{%egood_entity}}", "file_id", "{{%uploaded_file}}", "id", 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('{{%egood_entity}}');

        return true;
    }
}
