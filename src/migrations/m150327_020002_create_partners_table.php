<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_020002_create_partners_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%partner}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_partner_id' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'city' => Schema::TYPE_STRING . ' DEFAULT \'\'',
            'url' => Schema::TYPE_STRING . ' DEFAULT \'\'',
            'webmoney_rub' => Schema::TYPE_STRING . ' DEFAULT \'\'',
            'field' => Schema::TYPE_STRING . ' DEFAULT \'\'',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'subscribers_count' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'subscribes_count' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'sales_count' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'clicks_count' => Schema::TYPE_INTEGER . ' DEFAULT \'0\'',
            'sales_sum' => Schema::TYPE_DECIMAL . ' DEFAULT \'0.0\'',
            'payments_sum' => Schema::TYPE_DECIMAL . ' DEFAULT \'0.0\'',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_partner_user_id", "{{%partner}}", "user_id", "{{%user}}", "id", 'CASCADE');
        $this->addForeignKey("FK_partner_parent_partner_id", "{{%partner}}", "parent_partner_id", "{{%partner}}", "id", 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('{{%partner}}');
    }
}
