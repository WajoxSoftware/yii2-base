<?php
namespace wajox\yii2base\models;

use yii\web\IdentityInterface;
use wajox\yii2base\models\query\UserQuery;

class User extends \wajox\yii2base\components\db\ActiveRecord implements IdentityInterface
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const DEFAULT_AVATAR_PATH = '@noImagePath';

    const VIEW_ROUTE = '/account/default/view';

    const ROLE_USER = 'user';
    const ROLE_PARTNER = 'partner';
    const ROLE_MANAGER = 'manager';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_ADMIN = 'admin';

    const GENDER_UNKNOWN = 'unknown';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    public $password;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['confirmed_email', 'confirmation_token', 'name', 'first_name', 'last_name', 'email', 'phone', 'gender', 'role', 'guid', 'password_reset_token'], 'filter', 'filter' => 'strip_tags'],
            [['confirmed_email', 'confirmation_token', 'name', 'first_name', 'last_name', 'email', 'phone', 'gender', 'role', 'guid', 'password_reset_token'], 'filter', 'filter' => 'htmlentities'],
            [['confirmed_email', 'confirmation_token', 'name','first_name', 'last_name',  'email', 'phone', 'gender', 'role', 'guid', 'password_reset_token'], 'filter', 'filter' => 'trim'],
            [['name', 'created_at', 'role', 'guid'], 'required'],
            [['name', 'email', 'first_name', 'last_name'], 'required', 'on' => ['signup', 'update']],
            [['password'], 'required', 'on' => ['signup', 'change_password']],
            [['referal_user_id', 'created_at', 'confirmed_at', 'display_in_search', 'last_login_at'], 'integer'],
            [['confirmed_email', 'confirmation_token', 'email', 'password', 'password_reset_token', 'name', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'validateEmailUnique'],
            [['name'], 'validateNameUnique'],
            [['avatar_file_id'], 'required', 'on' => 'upload_avatar'],
            [['birthdate'], 'default', 'value' => date('Y-m-d')],
            [['birthdate'], 'date', 'format' => 'yyyy-mm-dd'],
            [['gender'], 'default', 'value' => 'unknown'],
            [['phone'], 'match', 'pattern' => '/^[0-9\)\(\+\-)]\w*$/i'],
            [['phone'], 'string', 'max' => 20, 'min' => 2],
            [['guid', 'ip_address'], 'string', 'max' => 255],
            [['gender'], 'in', 'range' => array_keys(self::getGenderList())],
            [['role'], 'in', 'range' => array_keys(self::getRoleList())],
            [['display_in_search'], 'in', 'range' => [0, 1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'referal_user_id' => \Yii::t('app/attributes', 'User Partner ID'),
            'email' => \Yii::t('app/attributes', 'Email'),
            'confirmed_email' => \Yii::t('app/attributes', 'Confirmed Email'),
            'confirmed_at' => \Yii::t('app/attributes', 'Confirmed At'),
            'confirmation_token' => \Yii::t('app/attributes', 'Confirmation Token'),
            'password_reset_token' => \Yii::t('app/attributes', 'Password Reset Token'),
            'password' => \Yii::t('app/attributes', 'Password'),
            'avatar_file_id' => \Yii::t('app/attributes', 'Avatar'),
            'name' => \Yii::t('app/attributes', 'Login'),
            'first_name' => \Yii::t('app/attributes', 'First Name'),
            'last_name' => \Yii::t('app/attributes', 'Last Name'),
            'role' => \Yii::t('app/attributes', 'Role'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'phone' => \Yii::t('app/attributes', 'Phone'),
            'gender' => \Yii::t('app/attributes', 'Gender'),
            'birthdate' => \Yii::t('app/attributes', 'Birthdate'),
            'account_balance' => \Yii::t('app/attributes', 'Account Balance'),
            'last_login_at' => \Yii::t('app/attributes', 'Last Login At'),
        ];
    }

    public static function find()
    {
        return \Yii::createObject(UserQuery::className(), [get_called_class()]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->byAccessToken($token);
    }

    public static function findByNameOrEmail($name)
    {
        return static::find()->byNameOrEmail($name, $name)->one();
    }

    public static function findByPasswordResetToken($token)
    {
        $expire = $this->getApp()->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return;
        }

        return static::find()->byResetToken($token)->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password_hash == $this->getApp()->getSecurity()->generatePasswordHash($password);
    }

    public function setPassword($password)
    {
        $this->password = $password;
        $this->password_hash = $this->getApp()->getSecurity()->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = md5($this->getApp()->getSecurity()->generateRandomKey());
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = $this->getApp()->getSecurity()->generateRandomKey().'_'.time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function generatePassword()
    {
        $newPassword = substr(hash('sha512', rand()), 0, 8);

        $this->setPassword($newPassword);
    }

    public function generateConfirmationToken($token = null)
    {
        $this->confirmation_token = $token == null ? md5(time() . $this->email) : $token;
        $this->confirmed_at = 0;
    }

    public function validateEmailUnique($attribute, $params)
    {
        $user = self::find()->byEmail($this->$attribute)->one();
        if ($user && ($this->isNewRecord || $this->id != $user->id)) {
            $this->addError($attribute, \Yii::t('app/validation', 'Email already in use'));
        }
    }

    public function validateNameUnique($attribute, $params)
    {
        $user = self::find()->byNameOrEmail($this->$attribute, $this->$attribute)->one();

        if ($user && ($this->isNewRecord || $this->id != $user->id)) {
            $this->addError($attribute, \Yii::t('app/validation', 'Name already in use'));
        }
    }

    public function getIsAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function getIsManager()
    {
        return $this->role == self::ROLE_MANAGER;
    }

    public function getIsEmployee()
    {
        return $this->role == self::ROLE_EMPLOYEE;
    }

    public function getIsPartner()
    {
        return $this->role == self::ROLE_PARTNER;
    }

    public function getIsUser()
    {
        return $this->role == self::ROLE_USER;
    }

    public function getHasTrafficAccount()
    {
        return \Yii::trafficManager != null && $this->isManager;
    }

    public function getHasPartnerAccount()
    {
        return $this->partner != null && $this->isPartner;
    }

    public function isConfirmed()
    {
        return $this->email == $this->confirmed_email;
    }

    public function getAvatarUrl()
    {
        $file = $this->avatarImage ? $this->avatarImage->previewUrl : \Yii::getAlias(self::DEFAULT_AVATAR_PATH);

        return $file;
    }

    public function getGender()
    {
        $list = self::getGenderList();

        return isset($list[$this->gender]) ? $list[$this->gender] : $list['unknown'];
    }

    public function getRoleName()
    {
        $list = self::getRoleList();

        return isset($list[$this->role]) ? $list[$this->role] : $list[self::ROLE_USER];
    }

    public static function getRoleList()
    {
        return [
            self::ROLE_USER => \Yii::t('app/attributes', 'User Role User'),
            self::ROLE_PARTNER => \Yii::t('app/attributes', 'User Role Partner'),
            self::ROLE_EMPLOYEE => \Yii::t('app/attributes', 'User Role Employee'),
            self::ROLE_MANAGER => \Yii::t('app/attributes', 'User Role Manager'),
            self::ROLE_ADMIN => \Yii::t('app/attributes', 'User Role Admin'),
        ];
    }

    public static function getUsersRoleList()
    {
        return [
            self::ROLE_USER => \Yii::t('app/attributes', 'User Role User'),
            self::ROLE_PARTNER => \Yii::t('app/attributes', 'User Role Partner'),
        ];
    }

    public static function getEmployeesRoleList()
    {
        return [
            self::ROLE_EMPLOYEE => \Yii::t('app/attributes', 'User Role Employee'),
            self::ROLE_MANAGER => \Yii::t('app/attributes', 'User Role Manager'),
            self::ROLE_ADMIN => \Yii::t('app/attributes', 'User Role Admin'),
        ];
    }

    public static function getGenderList()
    {
        return [
            self::GENDER_UNKNOWN => \Yii::t('app/attributes', 'Gender Unknown'),
            self::GENDER_MALE => \Yii::t('app/attributes', 'Gender Male'),
            self::GENDER_FEMALE => \Yii::t('app/attributes', 'Gender Female'),
        ];
    }

    public function updateBalance($sum)
    {
        if ($this->account_balance + $sum < 0) {
            return false;
        }

        $this->account_balance += $sum;

        return $this->save();
    }

    public function getAccountBalanceRUR()
    {
        return number_format($this->account_balance, 2);
    }

    public function getNewInboxMessagesCount()
    {
        return MessageUserStatus::find()->where([
                'user_id' => $this->id,
                'status_id' => MessageUserStatus::STATUS_ID_NEW,
            ])->count();
    }

    public function getContactsCount()
    {
        return UserContact::find()->where(['user_id' => $this->id])->count();
    }

    public function getRequestsCount()
    {
        return ContactRequest::find()->where(['contact_user_id' => $this->id])->count();
    }

    public function getNotificationsEnabled()
    {
        if ($this->settings == null) {
            return false;
        }

        return $this->settings->notificationsEnabled;
    }

    //relations
    public function getNetworkAccounts()
    {
        return $this->hasMany(UserNetworkAccount::className(), ['user_id' => 'id']);
    }

    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['user_id' => 'id'])->orWhere(['guid' => $this->guid]);
    }

    public function getSubscribes()
    {
        return $this->hasMany(Subscribe::className(), ['user_id' => 'id'])->orWhere(['guid' => $this->guid]);
    }

    public function getStatistics()
    {
        return $this->hasMany(Statistic::className(), ['user_id' => 'id'])->orWhere(['guid' => $this->guid]);
    }

    public function getUserActionLogs()
    {
        return $this->hasMany(UserActionLog::className(), ['user_id' => 'id'])->orWhere(['guid' => $this->guid]);
    }

    public function getSettings()
    {
        return $this->hasOne(UserSettings::className(), ['id' => 'id']);
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['user_id' => 'id']);
    }

    public function getAvatarImage()
    {
        return $this->hasOne(UploadedImage::className(), ['id' => 'avatar_file_id']);
    }

    public function getTrafficManager()
    {
        return $this->hasOne(TrafficManager::className(), ['user_id' => 'id']);
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['user_id' => 'id']);
    }

    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['user_id' => 'id']);
    }

    public function getSubaccounts()
    {
        return $this->hasMany(UserSubaccount::className(), ['user_id' => 'id']);
    }

    public function getContacts()
    {
        return $this->hasMany(UserContact::className(), ['user_id' => 'id']);
    }

    public function getRequests()
    {
        return $this->hasMany(ContactRequest::className(), ['contact_user_id' => 'id']);
    }

    public function getDialogs()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'dialog_id'])
            ->viaTable(DialogUser::tableName(), ['user_id' => 'id']);
    }

    public function getNameWithEmail()
    {
        return $this->name.'('.$this->email.')';
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getHasPartner()
    {
        return $this->partner != null;
    }

    public function getHasTrafficManager()
    {
        return \Yii::trafficManager != null;
    }

    public function getViewUrl()
    {
        return \yii\helpers\Url::toRoute([self::VIEW_ROUTE, 'id' => $this->id]);
    }

    public function getJson()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
        ];
    }
}
