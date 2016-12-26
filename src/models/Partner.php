<?php
namespace wajox\yii2base\models;

class Partner extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const SCENARIO_SIGNUP = 'signup';
    
    const TYPE_ID_DIRECT = 100;
    const TYPE_ID_MAIN = 101;
    const TYPE_ID_CASUAL = 102;

    public static function tableName()
    {
        return 'partner';
    }

    public function rules()
    {
        return [
            [['city', 'url', 'webmoney_rub', 'field'], 'filter', 'filter' => 'strip_tags'],
            [['city', 'webmoney_rub', 'field'], 'filter', 'filter' => 'htmlentities'],
            [['city', 'url', 'webmoney_rub', 'field'], 'filter', 'filter' => 'trim'],
            [['user_id', 'subscribers_count', 'type_id'], 'required'],
            [['user_id', 'parent_partner_id', 'subscribers_count', 'subscribes_count', 'sales_count', 'clicks_count', 'created_at'], 'integer'],
            [['sales_sum', 'payments_sum'], 'double', 'min' => 0],
            [['city', 'url', 'webmoney_rub', 'field'], 'string', 'max' => 255],
            [['url'], 'url'],
            [['user_id'], 'unique'],
            ['type_id', 'in', 'range' => array_keys($this::getTypeIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'Partner User ID'),
            'parent_partner_id' => \Yii::t('app/attributes', 'Partner Parent Partner ID'),
            'city' => \Yii::t('app/attributes', 'City'),
            'url' => \Yii::t('app/attributes', 'Url'),
            'webmoney_rub' => \Yii::t('app/attributes', 'Partner Webmoney Rub'),
            'field' => \Yii::t('app/attributes', 'Partner Field'),
            'type_id' => \Yii::t('app/attributes', 'Partner Type'),
            'subscribers_count' => \Yii::t('app/attributes', 'Partner Subscribers Count'),
            'subscribes_count' => \Yii::t('app/attributes', 'Partner Subscribes Count'),
            'clicks_count' => \Yii::t('app/attributes', 'Partner Clicks Count'),
            'sales_count' => \Yii::t('app/attributes', 'Partner Sales Count'),
            'sales_sum' => \Yii::t('app/attributes', 'Partner Sales Sum'),
            'payments_sum' => \Yii::t('app/attributes', 'Partner Payments Sum'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_CASUAL => \Yii::t('app/attributes', 'Partner Type Casual'),
            self::TYPE_ID_DIRECT => \Yii::t('app/attributes', 'Partner Type Direct'),
            self::TYPE_ID_MAIN => \Yii::t('app/attributes', 'Partner Type Main'),
        ];
    }

    public function getPartnerType()
    {
        $list = $this::getTypeIdList();

        return $list[$this->type_id];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPartners()
    {
        return $this->hasMany(self::className(), ['parent_partner_id' => 'id']);
    }

    public function getParentPartner()
    {
        return $this->hasMany(self::className(), ['id' => 'parent_partner_id']);
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

    public function getFullName()
    {
        return $this->user->fullName;
    }
}
