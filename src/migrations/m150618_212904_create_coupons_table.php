<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_212904_create_coupons_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_user_coupon}}', [
            'id' => Schema::TYPE_PK,
            'partner_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sum' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'start_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'finish_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'extra' => Schema::TYPE_TEXT . ' DEFAULT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_gu_coupon_partner_id", "{{%good_user_coupon}}", "partner_id", "{{%partner}}", "id", 'CASCADE');
        $this->addForeignKey("FK_gu_coupon_good_id", "{{%good_user_coupon}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_user_coupon}}');

        return true;
    }
}
