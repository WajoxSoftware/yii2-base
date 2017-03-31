<?php
use yii\db\Schema;
use yii\db\Migration;

class m151123_134618_create_traffic_source_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%traffic_source}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING,
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag' => Schema::TYPE_STRING,
            'target_url' => Schema::TYPE_STRING. ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_traffic_source_user_id", "{{%traffic_source}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_source}}');

        return true;
    }
}
