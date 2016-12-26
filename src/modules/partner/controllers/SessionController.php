<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\modules\partner\models\LoginForm;

class SessionController extends \wajox\yii2base\controllers\SessionControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/partner']);
    }

    protected function goLoginPage()
    {
        return $this->redirect(['/partner/session']);
    }

    protected function getLoginForm()
    {
        return $this->createObject(LoginForm::className());
    }
}
