<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_020036_CreateGoodTagsTable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%good_tag}}', [
            'id' => Schema::TYPE_PK,
            'repeat_count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT \'0\'',
            'name' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT \'active\'',
        ], $tableOptions);

        $this->createIndex('name', '{{%good_tag}}', 'name', true);
    }

    public function down()
    {
        $this->dropTable('{{%good_tag}}');

        return true;
    }
}
