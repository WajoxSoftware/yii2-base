<?php

use yii\db\Migration;
use yii\db\Schema;

class m160603_133310_add_good_letter_email extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_letter_email}}', [
            'id' => Schema::TYPE_PK,
            'good_email_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'order_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' =>  Schema::TYPE_INTEGER . ' NOT NULL',
            'send_at' => Schema::TYPE_INTEGER . ' NULL',
            'scheduled_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addForeignKey("FK_good_letteremail_email_id", "{{%good_letter_email}}", "good_email_id", "{{%good_letter}}", "id", 'CASCADE');
        $this->addForeignKey("FK_good_letteremail_order_id", "{{%good_letter_email}}", "order_id", "{{%order}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_letter_email}}');

        return true;
    }
}
