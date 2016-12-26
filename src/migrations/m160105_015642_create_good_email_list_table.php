<?php
use yii\db\Schema;
use yii\db\Migration;

class m160105_015642_create_good_email_list_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%good_email_list}}', [
            'id' => $this->primaryKey(),
            'good_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'email_list_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_good_elist_good_id", "{{%good_email_list}}", "good_id", "{{%good}}", "id", 'CASCADE');
        $this->addForeignKey("FK_good_elist_list_id", "{{%good_email_list}}", "email_list_id", "{{%email_list}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%good_email_list}}');
    }
}
