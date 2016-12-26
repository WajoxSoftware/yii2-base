<?php
use yii\db\Schema;
use yii\db\Migration;

class m150327_020004_create_traffic_managers_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%traffic_manager}}', [
            'id' => $this->primaryKey(),
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_traffic_manager_user_id", "{{%traffic_manager}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%traffic_manager}}');
    }
}
