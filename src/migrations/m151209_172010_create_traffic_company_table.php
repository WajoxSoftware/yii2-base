<?php
use yii\db\Schema;
use yii\db\Migration;

class m151209_172010_create_traffic_company_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%traffic_company}}', [
            'id' => Schema::TYPE_PK,
            'traffic_stream_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addForeignKey("FK_traffic_company_stream_id", "{{%traffic_company}}", "traffic_stream_id", "{{%traffic_stream}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_company}}');

        return true;
    }
}
