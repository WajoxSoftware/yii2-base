<?php
use yii\db\Schema;
use yii\db\Migration;

class m151209_172131_create_traffic_stream_price_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%traffic_stream_price}}', [
            'id' => Schema::TYPE_PK,
            'traffic_stream_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'started_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT \'0\'',
            'finished_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT \'4733510400\'',
            'clicks_count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'sum' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
        ], $tableOptions);

        $this->addForeignKey("FK_traffic_sprice_stream_id", "{{%traffic_stream_price}}", "traffic_stream_id", "{{%traffic_stream}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_stream_price}}');

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
