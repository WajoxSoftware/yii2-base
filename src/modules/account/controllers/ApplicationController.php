<?php
namespace wajox\yii2base\modules\account\controllers;

class ApplicationController extends \wajox\yii2base\controllers\AuthenticatedController
{
    public function signInRedirect()
    {
        return $this->redirect('/account/session');
    }
}
