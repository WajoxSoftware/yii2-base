<?php
namespace wajox\yii2base\modules\trafficmanager\controllers;

class ApplicationController extends \wajox\yii2base\controllers\AuthenticatedController
{
    public function signInRedirect()
    {
        return $this->redirect('/trafficmanager/session');
    }

    protected function isValidUser($user)
    {
        if ($user == null) {
            return false;
        }

        return $user->hasTrafficManager;
    }
}
