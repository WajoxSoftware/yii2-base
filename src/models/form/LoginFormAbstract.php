<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\models\User;
use wajox\yii2base\services\users\UsersManager;

abstract class LoginFormAbstract extends Model
{
    public $name;
    public $password;
    public $rememberMe = true;

    protected $_user = null;

    public function rules()
    {
        return [
            // username and password are both required
            [['name'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'filter', 'filter' => 'trim'],
            [['name', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if ($user && $this->getApp()->getSecurity()->validatePassword($this->$attribute, $user->password_hash)) {
                return;
            }

            $this->addError($attribute, \Yii::t('app/validation', 'Incorrect login/email or password'));
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->last_login_at = time();
            $user->save();

            return $this->getDependency(UsersManager::className())->signIn($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = $this
                ->getRepository()
                ->find(User::className())
                ->byNameOrEmail($this->name, $this->name)
                ->one();
        }

        return $this->_user;
    }

    public function setUser($user)
    {
        $this->_user = $user;

        return $this;
    }

    protected function userExists()
    {
        return $this->getUser() != null;
    }

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app/attributes', 'Login'),
            'password' => \Yii::t('app/attributes', 'Password'),
            'rememberMe' => \Yii::t('app/attributes', 'Remember Me'),
        ];
    }
}
