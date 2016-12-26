<?php

use yii\db\Migration;
use yii\db\Schema;

class m160407_141845_create_system_delivery_settings_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_delivery_settings}}', [
            'id' => Schema::TYPE_PK,
            'delivery_sum' => Schema::TYPE_DECIMAL . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%good_delivery_settings}}');

        return true;
    }
}
