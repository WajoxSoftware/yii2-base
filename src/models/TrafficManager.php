<?php
namespace wajox\yii2base\models;

class TrafficManager extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'traffic_manager';
    }

    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'filter', 'filter' => 'htmlentities'],
            [['name'], 'filter', 'filter' => 'trim'],
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['user_id', 'name'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'name' => \Yii::t('app/attributes', 'Name'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSubaccounts()
    {
        return $this->hasMany(UserSubaccount::className(), ['user_id' => 'user_id']);
    }

    public function getStreams()
    {
        return $this->hasMany(TrafficStream::className(), ['user_id' => 'user_id']);
    }

    public function getSources()
    {
        return $this->hasMany(TrafficSource::className(), ['user_id' => 'user_id']);
    }
}
