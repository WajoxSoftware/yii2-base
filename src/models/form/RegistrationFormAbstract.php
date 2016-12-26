<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\services\users\UsersManager;
use wajox\yii2base\models\User;

class RegistrationFormAbstract extends Model
{
    public $name;
    public $first_name;
    public $last_name;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['name', 'first_name', 'last_name', 'email'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'first_name', 'last_name', 'email'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'first_name', 'last_name'], 'required'],
            [['name', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\wajox\yii2base\models\User', 'message' => \Yii::t('app/validation', 'Email already in use')],
            ['name', 'unique', 'targetClass' => '\wajox\yii2base\models\User', 'message' => \Yii::t('app/validation', 'Name already in use')],
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = $this->getManager()->save($this->getUser());

            if ($user == null
                || $user->isNewRecord
            ) {
                return;
            }

            if (!$this->afterSignUp($user)) {
                $user->delete();

                return;
            }

            return $user;
        }

        return;
    }

    public function getUser()
    {
        $user = $this->createObject(
            User::className(),
            [['scenario' => 'signup']]
        );
        $user->setPassword($this->password);
        $user->role = User::ROLE_USER;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;

        return $user;
    }

    public function afterSignUp($user)
    {
        return true;
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app/attributes', 'Email'),
            'password' => \Yii::t('app/attributes', 'Password'),
            'name' => \Yii::t('app/attributes', 'Login'),
            'first_name' => \Yii::t('app/attributes', 'First Name'),
            'last_name' => \Yii::t('app/attributes', 'Last Name'),
        ];
    }

    public function getManager()
    {
        return $this->getDependency(UsersManager::className());
    }
}
