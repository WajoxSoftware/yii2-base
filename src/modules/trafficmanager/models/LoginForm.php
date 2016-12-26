<?php
namespace wajox\yii2base\modules\trafficmanager\models;

use wajox\yii2base\models\User;

class LoginForm extends \wajox\yii2base\models\form\LoginFormAbstract
{
    public function login()
    {
        if (!$this->userExists()
            && !$this->validate()
        ) {
            return false;
        }

        $user = $this->getUser();

        if (!$user || !$user->hasTrafficManager) {
            return false;
        }

        return $this->getApp()->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
