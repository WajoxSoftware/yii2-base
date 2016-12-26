<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\modules\partner\models\RegistrationForm;

class RegistrationController extends \wajox\yii2base\controllers\RegistrationControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/partner']);
    }

    protected function getRegistrationForm()
    {
        return $this->createObject(RegistrationForm::className());
    }
}
