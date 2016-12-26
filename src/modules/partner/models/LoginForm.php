<?php
namespace wajox\yii2base\modules\partner\models;

use wajox\yii2base\models\User;

class LoginForm extends \wajox\yii2base\models\form\LoginFormAbstract
{
    public function login()
    {
        if ($this->userExists() || $this->validate()) {
            $user = $this->getUser();
            if ($user && $user->isPartner) {
                return $this->getApp()->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
