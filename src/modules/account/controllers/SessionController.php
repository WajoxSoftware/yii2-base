<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\modules\account\models\LoginForm;

class SessionController extends \wajox\yii2base\controllers\SessionControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/account']);
    }

    protected function goLoginPage()
    {
        return $this->redirect(['/account/session']);
    }

    protected function getLoginForm()
    {
        return $this->createObject(LoginForm::className());
    }
}
