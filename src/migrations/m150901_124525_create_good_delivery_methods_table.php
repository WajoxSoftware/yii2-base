<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_124525_create_good_delivery_methods_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_delivery_method}}', [
            'id' => Schema::TYPE_PK,
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delivery_method' => Schema::TYPE_STRING . ' NOT NULL',
            'delivery_price' => Schema::TYPE_DECIMAL . ' DEFAULT NULL',
            'extra' => Schema::TYPE_TEXT,

        ], $tableOptions);

        $this->addForeignKey("FK_good_dmethod_good_id", "{{%good_delivery_method}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_delivery_method}}');

        return true;
    }
}
