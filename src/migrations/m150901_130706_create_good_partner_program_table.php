<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_130706_create_good_partner_program_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_partner_program}}', [
            'id' => Schema::TYPE_PK,
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'partner_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'fee_1_level' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'fee_2_level' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'partner_link' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
        ], $tableOptions);

        $this->addForeignKey("FK_good_pprogram_good_id", "{{%good_partner_program}}", "good_id", "{{%good}}", "id", 'CASCADE');
        $this->addForeignKey("FK_good_pprogram_partner_id", "{{%good_partner_program}}", "partner_id", "{{%partner}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_partner_program}}');
    }
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
