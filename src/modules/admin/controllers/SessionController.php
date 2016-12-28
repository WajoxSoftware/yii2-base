<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\modules\admin\models\LoginForm;

class SessionController extends \wajox\yii2base\controllers\SessionControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/admin']);
    }

    protected function goLoginPage()
    {
        return $this->redirect(['/admin/session']);
    }

    protected function getLoginForm()
    {
        return $this->createObject(LoginForm::className());
    }
}
