<?php
use yii\db\Migration;
use yii\db\Schema;

class m160517_210815_create_tunnels_table extends Migration
{
    public function up()
    {
        $this->createTable('traffic_tunnel', [
            'id' => $this->primaryKey(),
            'title' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('traffic_tunnel');
    }
}
