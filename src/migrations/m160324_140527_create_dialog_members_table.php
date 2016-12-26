<?php
use yii\db\Migration;
use yii\db\Schema;

class m160324_140527_create_dialog_members_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%dialog_members}}', [
            'id' => $this->primaryKey(),
            'users_ids' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->createIndex('users_ids', '{{%dialog_members}}', 'users_ids');
    }

    public function down()
    {
        $this->dropTable('{{%dialog_members}}');
    }
}
