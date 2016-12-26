<?php
namespace wajox\yii2base\models;

class TrafficCompany extends \wajox\yii2base\components\db\ActiveRecord
{
    const DEFAULT_IMAGE_PATH = '@noImagePath';

    public static function tableName()
    {
        return 'traffic_company';
    }

    public function rules()
    {
        return [
            [['traffic_stream_id'], 'required'],
            [['traffic_stream_id'], 'integer'],
            [['content'], 'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'traffic_stream_id' => \Yii::t('app/attributes', 'Traffic Stream ID'),
            'content' => \Yii::t('app/attributes', 'Content'),
        ];
    }

    public function getStream()
    {
        return $this->hasOne(TrafficStream::className(), ['id' => 'traffic_stream_id']);
    }
}
