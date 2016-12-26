<?php
namespace wajox\yii2base\models;

class TrafficTunnel extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'traffic_tunnel';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'filter', 'filter' => 'strip_tags'],
            [['title'], 'filter', 'filter' => 'htmlentities'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
        ];
    }

    public function getSteps()
    {
        return $this->hasMany(TrafficTunnelStep::className(), ['traffic_tunnel_id' => 'id'])->orderBy('[[position]] ASC');
    }
}
