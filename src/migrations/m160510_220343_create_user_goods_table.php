<?php

use yii\db\Migration;
use yii\db\Schema;

class m160510_220343_create_user_goods_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_paid_good}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'good_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_user_pgood_user_id", "{{%user_paid_good}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_user_pgood_good_id", "{{%user_paid_good}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_paid_good}}');

        return true;
    }
}
