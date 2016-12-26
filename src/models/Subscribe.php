<?php
namespace wajox\yii2base\models;

class Subscribe extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_DELETED = 101;

    public static function tableName()
    {
        return 'subscribe';
    }

    public function rules()
    {
        return [
            [['email', 'name', 'phone'], 'filter', 'filter' => 'strip_tags'],
            [['email', 'name', 'phone'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['email_list_id', 'user_id', 'created_at', 'referal_user_id', 'partner_subaccount_id', 'status_id'], 'integer'],
            [['email_list_id', 'name', 'phone', 'email', 'created_at', 'guid', 'status_id'], 'required'],
            [['guid', 'name', 'phone', 'email'], 'string', 'max' => 255],
            ['email', 'unique', 'targetAttribute' => ['email_list_id', 'email']],
            [['status_id'], 'in', 'range' => array_keys(self::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'email_list_id' => \Yii::t('app/attributes', 'Email List ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'name' => \Yii::t('app/attributes', 'Name'),
            'phone' => \Yii::t('app/attributes', 'Phone'),
            'email' => \Yii::t('app/attributes', 'Email'),
            'status_id' => \Yii::t('app/attributes', 'Status ID'),
            'ip_address' => \Yii::t('app/attributes', 'Ip Address'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => 'new',
            self::STATUS_ID_DELETED => 'deleted',
        ];
    }

    public function getEmailList()
    {
        return $this->hasOne(EmailList::className(), ['id' => 'email_list_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getStream()
    {
        return $this->hasOne(TrafficStream::className(), ['id' => 'traffic_stream_id']);
    }

    public function getPartnerSubaccount()
    {
        return $this->hasOne(UserSubaccount::className(), ['id' => 'partner_subaccount_id']);
    }

    public function getUserName()
    {
        if ($this->user == null) {
            return 'None';
        }

        return $this->user->nameWithEmail;
    }

    public function getPartnerName()
    {
        if ($this->partner == null) {
            return 'None';
        }

        return $this->partner->user->nameWithEmail;
    }

    public function getSubaccountTag()
    {
        if ($this->partnerSubaccount == null) {
            return 'None';
        }

        return $this->partnerSubaccount->tag;
    }

    public function getUserActionLogs()
    {
        return $this->hasMany(UserActionLog::className(), ['user_id' => 'user_id'])->orWhere(['guid' => $this->guid]);
    }
}
