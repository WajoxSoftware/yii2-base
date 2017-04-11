<?php
namespace wajox\yii2base\modules\payment\models;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Log;
use wajox\yii2base\modules\payment\models\query\CustomerQuery;

class Customer extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const STATUS_ID_ACTIVE = 0;
    const STATUS_ID_BLOCKED = 100;

    public static function tableName()
    {
        return 'customer';
    }

    public function rules()
    {
        return [
            [['full_name', 'email', 'city', 'country', 'region', 'address', 'uniqid'], 'filter', 'filter' => 'strip_tags'],
            [['full_name', 'email', 'city', 'country', 'region', 'address', 'uniqid', 'guid', 'phone', 'postalcode'], 'filter', 'filter' => 'htmlentities'],
            [['full_name', 'email', 'city', 'country', 'region', 'address', 'uniqid', 'guid', 'phone', 'postalcode'], 'filter', 'filter' => 'trim'],
            [['user_id', 'referal_user_id', 'created_at'], 'integer'],
            [['full_name', 'email', 'phone', 'created_at', 'guid', 'user_id', 'uniqid'], 'required'],
            [['full_name', 'email', 'address', 'country', 'region', 'city', 'guid', 'uniqid'], 'string', 'max' => 255],
            [['referal_user_id', 'created_at', 'user_id'], 'integer'],
            [['email'], 'email'],
            [['phone'], 'match', 'pattern' => '/^[0-9\)\(\+\-)]\w*$/i'],
            [['phone'], 'string', 'max' => 20, 'min' => 2],
            [['postalcode'], 'match', 'pattern' => '/^[0-9]\w*$/i'],
            [['postalcode'], 'string', 'max' => 10, 'min' => 5],
            [['uniqid'], 'unique'],
            [['status_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'referal_user_id' => \Yii::t('app/attributes', 'Referal User ID'),
            'full_name' => \Yii::t('app/attributes', 'Full Name'),
            'email' => \Yii::t('app/attributes', 'Email'),
            'phone' => \Yii::t('app/attributes', 'Phone'),
            'postalcode' => \Yii::t('app/attributes', 'Postal Code'),
            'country' => \Yii::t('app/attributes', 'Country'),
            'region' => \Yii::t('app/attributes', 'Region'),
            'city' => \Yii::t('app/attributes', 'City'),
            'address' => \Yii::t('app/attributes', 'Address'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'uniqid' => \Yii::t('app/attributes', 'ID'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
        ];
    }

    public static function find()
    {
        return self::createObject(
            CustomerQuery::className(),
            [get_called_class()]
        );
    }

    public static function getStatusIdsList()
    {
        return [
            self::STATUS_ID_ACTIVE => \Yii::t('app/attributes', 'Customer Status Active'),
            self::STATUS_ID_BLOCKED => \Yii::t('app/attributes', 'Customer Status Blocked'),
        ];
    }

    public function getStatus()
    {
        return self::getStatusIdsList()[$this->status_id];
    }

    public function getIsBlocked()
    {
        return $this->status_id == self::STATUS_ID_BLOCKED;
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getReferalUser()
    {
        return $this->hasOne(User::className(), ['id' => 'referal_user_id']);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public function getBills()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['user_id' => 'user_id'])->orWhere(['guid' => $this->guid]);
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function getFirstName()
    {
        return $this->getFullNamePart(0);
    }

    public function getLastName()
    {
        return $this->getFullNamePart(1);
    }

    public function getPartner()
    {
        if ($this->referalUser != null) {
            return $this->referalUser->partner;
        }

        return;
    }

    public function getFullAddress()
    {
        $parts = [];

        $parts[] = $this->postalcode;
        $parts[] = $this->country;
        $parts[] = $this->region;
        $parts[] = $this->city;
        $parts[] = $this->address;

        $parts = array_diff($parts, ['']);

        return implode(', ', $parts);
    }

    protected function getFullNamePart($index)
    {
        $parts = explode(' ', $this->fullName);

        if (isset($parts[$index])) {
            return $parts[$index];
        }
    }
}
