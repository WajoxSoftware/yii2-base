<?php
use yii\db\Schema;
use yii\db\Migration;

class m151021_115040_create_statistics_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%statistic}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'guid' => Schema::TYPE_STRING . ' NOT NULL',
            'page_url' => Schema::TYPE_STRING . ' NOT NULL',
            'page_title' => Schema::TYPE_STRING . ' NOT NULL',
            'ref_page_url' => Schema::TYPE_STRING . ' NOT NULL',
            'browser_data' => Schema::TYPE_STRING . ' NOT NULL',
            'scroll' => Schema::TYPE_INTEGER . ' NOT NULL',
            'screen_size' => Schema::TYPE_STRING . ' NOT NULL',
            'spend_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('guid', '{{%statistic}}', 'guid');

        $this->addForeignKey("FK_statistic_user_id", "{{%statistic}}", "user_id", "{{%user}}", "id", 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%statistic}}');

        return true;
    }
}
