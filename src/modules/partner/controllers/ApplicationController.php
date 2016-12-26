<?php
namespace wajox\yii2base\modules\partner\controllers;

use yii\web\NotFoundHttpException;

class ApplicationController extends \wajox\yii2base\controllers\AuthenticatedController
{
    public function getPartner()
    {
        $user = $this->getApp()->user->identity;
        if ($user->isPartner) {
            return $user->partner;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function signInRedirect()
    {
        return $this->redirect(['/partner/session']);
    }

    protected function isValidUser($user)
    {
        if ($user == null) {
            return false;
        }

        return $user->isPartner;
    }
}
