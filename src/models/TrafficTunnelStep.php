<?php
namespace wajox\yii2base\models;

class TrafficTunnelStep extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'traffic_tunnel_step';
    }

    public function rules()
    {
        return [
            [['traffic_tunnel_id', 'position', 'title', 'action_type_id'], 'required'],
            [['traffic_tunnel_id', 'position', 'action_type_id'], 'integer'],
            [['title', 'action_params'], 'filter', 'filter' => 'strip_tags'],
            [['title'], 'filter', 'filter' => 'htmlentities'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title', 'action_params'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'traffic_tunnel_id' => \Yii::t('app/attributes', 'Traffic Tunnel ID'),
            'position' => \Yii::t('app/attributes', 'Position'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'action_type_id' => \Yii::t('app/attributes', 'Action Type ID'),
            'action_params' => \Yii::t('app/attributes', 'Action Params'),
        ];
    }

    public static function getActionTypeIdList()
    {
        return \wajox\yii2base\models\UserActionLog::getActionTypeIdList();
    }

    public function getTitle()
    {
        $ls = self::getActionTypeIdList();

        return $ls[$this->action_type_id];
    }
}
