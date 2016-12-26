<?php
namespace wajox\yii2base\models;

class TrafficStreamGood extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'traffic_stream_good';
    }

    public function rules()
    {
        return [
            [['traffic_stream_id', 'good_id'], 'required'],
            [['traffic_stream_id', 'good_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'traffic_stream_id' => \Yii::t('app/attributes', 'Traffic Stream ID'),
            'good_id' => \Yii::t('app/attributes', 'Traffic Stream Good ID'),
        ];
    }
}
