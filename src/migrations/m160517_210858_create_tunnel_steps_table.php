<?php
use yii\db\Migration;
use yii\db\Schema;

class m160517_210858_create_tunnel_steps_table extends Migration
{
    public function up()
    {
        $this->createTable('traffic_tunnel_step', [
            'id' => $this->primaryKey(),
            'traffic_tunnel_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'action_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'action_params' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->addForeignKey("FK_traffic_step_tunnel_id", "{{%traffic_tunnel_step}}", "traffic_tunnel_id", "{{%traffic_tunnel}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('traffic_tunnel_step');
    }
}
