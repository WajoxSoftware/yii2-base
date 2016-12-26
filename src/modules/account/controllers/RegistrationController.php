<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\modules\account\models\RegistrationForm;

class RegistrationController extends \wajox\yii2base\controllers\RegistrationControllerAbstract
{
    protected function goDashboard()
    {
        return $this->redirect(['/account']);
    }

    protected function getRegistrationForm()
    {
        return $this->createObject(RegistrationForm::className());
    }
}
