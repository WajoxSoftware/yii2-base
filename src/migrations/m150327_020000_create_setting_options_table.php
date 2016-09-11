<?php
use yii\db\Migration;
use yii\db\Schema;

class m150327_020000_create_setting_options_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%setting_option}}', [
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'val' => Schema::TYPE_TEXT . ' NULL',
            'type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addPrimaryKey('key_pk', '{{%setting_option}}', 'key');
    }

    public function down()
    {
        $this->dropTable('{{%setting_option}}');

        return true;
    }
}
