<?php
namespace wajox\yii2base\modules\trafficmanager\controllers;

use wajox\yii2base\modules\trafficmanager\models\LoginForm;

class SessionController extends \wajox\yii2base\controllers\SessionControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/trafficmanager']);
    }

    protected function goLoginPage()
    {
        return $this->redirect(['/trafficmanager/session']);
    }

    protected function getLoginForm()
    {
        return $this->createObject(LoginForm::className());
    }
}
