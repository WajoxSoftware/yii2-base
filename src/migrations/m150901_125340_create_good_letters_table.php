<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_125340_create_good_letters_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_letter}}', [
            'id' => Schema::TYPE_PK,
            'good_id' => Schema::TYPE_INTEGER . ' NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delay' => Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT \'0.00\'',
            'title' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'Subject\'',
            'content_html' => Schema::TYPE_TEXT,
            'content_text' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->addForeignKey("FK_good_letter_good_id", "{{%good_letter}}", "good_id", "{{%good}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_letter}}');
    }
}
