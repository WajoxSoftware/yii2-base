<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_130721_create_good_partner_program_link_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_partner_program_link}}', [
            'id' => Schema::TYPE_PK,
            'good_partner_program_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
        ], $tableOptions);

        $this->addForeignKey("FK_good_pprograml_gpp_id", "{{%good_partner_program_link}}", "good_partner_program_id", "{{%good_partner_program}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_partner_program_link}}');
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
