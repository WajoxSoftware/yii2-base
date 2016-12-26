<?php
use yii\db\Schema;
use yii\db\Migration;

class m151228_011505_create_eatopay_order_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%eautopay_order}}', [
            'id' => $this->primaryKey(),
            'eautopay_order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL',
            'status_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex('eautopay_order_id', '{{%eautopay_order}}', 'eautopay_order_id', true);
    }

    public function down()
    {
        $this->dropTable('{{%eautopay_order}}');
    }
}
