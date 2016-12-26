<?php
use yii\db\Schema;
use yii\db\Migration;

class m151025_170322_create_partner_fee_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%partner_fee}}', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'partner_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sum' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'status_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->addForeignKey("FK_partner_fee_order_id", "{{%partner_fee}}", "order_id", "{{%order}}", "id", 'CASCADE');
        $this->addForeignKey("FK_partner_fee_partner_id", "{{%partner_fee}}", "partner_id", "{{%partner}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%partner_fee}}');

        return true;
    }
}
