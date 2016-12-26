<?php

use yii\db\Migration;
use yii\db\Schema;

class m160526_154945_crete_traffic_stream_images_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%traffic_stream_image}}', [
            'id' => Schema::TYPE_PK,
            'traffic_stream_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uploaded_image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_traffic_simage_stream_id", "{{%traffic_stream_image}}", "traffic_stream_id", "{{%traffic_stream}}", "id", 'CASCADE');
        $this->addForeignKey("FK_traffic_simage_image_id", "{{%traffic_stream_image}}", "uploaded_image_id", "{{%uploaded_file}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_stream_image}}');

        return true;
    }
}
