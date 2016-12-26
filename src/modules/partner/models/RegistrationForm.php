<?php
namespace wajox\yii2base\modules\partner\models;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;

class RegistrationForm extends \wajox\yii2base\models\form\RegistrationFormAbstract
{
    public $name;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $gender;
    public $birthdate;
    public $url = '';
    public $city = '';
    public $field = '';
    public $webmoney_rub = '';
    public $subscribers_count = 0;

    public function rules()
    {
        return [
            [['name', 'first_name', 'last_name', 'email', 'city', 'url', 'webmoney_rub', 'field'], 'filter', 'filter' => 'strip_tags'],
            [['email', 'name', 'first_name', 'last_name', 'email', 'city', 'url', 'webmoney_rub', 'field'], 'filter', 'filter' => 'trim'],
            [['name', 'first_name', 'last_name', 'email', 'password'], 'required'],
            //[['name', 'first_name', 'last_name', 'email', 'password', 'birthdate', 'gender', 'city', 'url', 'webmoney_rub', 'field', 'subscribers_count', 'phone'], 'required'],
            [['name', 'first_name', 'last_name', 'city', 'webmoney_rub', 'field'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            [['subscribers_count'], 'integer'],
            [['url'], 'url'],
            ['email', 'unique', 'targetClass' => '\wajox\yii2base\models\User', 'message' => \Yii::t('app/validation', 'Email already in use')],
            ['name', 'unique', 'targetClass' => '\wajox\yii2base\models\User', 'message' => \Yii::t('app/validation', 'Name already in use')],
            ['password', 'string', 'min' => 4],
            [['birthdate'], 'default', 'value' => date('Y-m-d')],
            [['birthdate'], 'date', 'format' => 'yyyy-mm-dd'],
            [['gender'], 'default', 'value' => 'unknown'],
            [['phone'], 'match', 'pattern' => '/^[0-9\)\(\+\-)]\w*$/i'],
            [['phone'], 'string', 'max' => 20, 'min' => 2],
            [['gender'], 'in', 'range' => array_keys(self::getGenderList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app/attributes', 'Email'),
            'password' => \Yii::t('app/attributes', 'Password'),
            'name' => \Yii::t('app/attributes', 'Login'),
            'first_name' => \Yii::t('app/attributes', 'First Name'),
            'last_name' => \Yii::t('app/attributes', 'Last Name'),
            'city' => \Yii::t('app/attributes', 'City'),
            'url' => \Yii::t('app/attributes', 'Url'),
            'webmoney_rub' => \Yii::t('app/attributes', 'Partner Webmoney Rub'),
            'field' => \Yii::t('app/attributes', 'Partner Field'),
            'phone' => \Yii::t('app/attributes', 'Phone'),
            'gender' => \Yii::t('app/attributes', 'Gender'),
            'birthdate' => \Yii::t('app/attributes', 'Birthdate'),
            'subscribers_count' => \Yii::t('app/attributes', 'Partner Subscribers Count'),

        ];
    }

    public static function getGenderList()
    {
        return User::getGenderList();
    }

    public function afterSignUp($user)
    {
        $partner = $this->createObject(Partner::className());
        $partner->user_id = $user->id;
        $partner->parent_partner_id = $this->getApp()->visitor->partnerId;
        $partner->type_id = Partner::TYPE_ID_CASUAL;
        $partner->webmoney_rub = $this->webmoney_rub;
        $partner->subscribers_count = $this->subscribers_count;
        $partner->url = $this->url;
        $partner->city = $this->city;
        $partner->field = $this->field;
        $partner->created_at = time();

        return $partner->save();
    }

    public function getUser()
    {
        $user = $this->createObject(
            User::className(),
            [['scenario' => 'signup']]
        );
        $user->setPassword($this->password);
        $user->role = User::ROLE_PARTNER;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->birthdate = $this->birthdate;
        $user->gender = $this->gender;
        $user->phone = $this->phone;

        return $user;
    }
}
