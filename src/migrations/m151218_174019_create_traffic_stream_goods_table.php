<?php
use yii\db\Schema;
use yii\db\Migration;

class m151218_174019_create_traffic_stream_goods_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%traffic_stream_good}}', [
            'id' => $this->primaryKey(),
            'traffic_stream_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_traffic_sgood_stream_id", "{{%traffic_stream_good}}", "traffic_stream_id", "{{%traffic_stream}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_stream_good}}');
    }
}
