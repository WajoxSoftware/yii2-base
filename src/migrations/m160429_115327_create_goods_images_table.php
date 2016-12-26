<?php
use yii\db\Migration;
use yii\db\Schema;

class m160429_115327_create_goods_images_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_image}}', [
            'id' => Schema::TYPE_PK,
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uploaded_image_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_good_image_good_id", "{{%good_image}}", "good_id", "{{%good}}", "id", 'CASCADE');
        $this->addForeignKey("FK_good_image_file_id", "{{%good_image}}", "uploaded_image_id", "{{%uploaded_file}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_image}}');

        return true;
    }
}
