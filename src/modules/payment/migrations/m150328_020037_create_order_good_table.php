<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_020037_create_order_good_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_good}}', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'items_count' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_order_good_order_id", "{{%order_good}}", "order_id", "{{%order}}", "id", 'CASCADE');
        $this->addForeignKey("FK_order_good_good_id", "{{%order_good}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%order_good}}');

        return true;
    }
}
