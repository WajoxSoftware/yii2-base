<?php
use yii\db\Schema;
use yii\db\Migration;

class m151123_134620_create_traffic_stream extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%traffic_stream}}', [
            'id' => Schema::TYPE_PK,
            'traffic_source_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING. ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addForeignKey("FK_traffic_stream_user_id", "{{%traffic_stream}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_traffic_stream_source_id", "{{%traffic_stream}}", "traffic_source_id", "{{%traffic_source}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_stream}}');

        return true;
    }
}
