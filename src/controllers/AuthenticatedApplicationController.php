<?php
namespace \wajox\yii2base\controllers;

use yii\filters\AccessControl;

abstract class AuthenticatedApplicationController extends ApplicationController
{
    public $settingsControllerClassName = 'app\modules\account\controllers\SettingsController';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $user = $this->getUser();

        if ($user && !$user->isConfirmed() &&
           $action->controller->className() != $this->settingsControllerClassName) {
            $this->accountSettingsRedirect();

            return false;
        }

        if (!$this->isValidUser($user)) {
            \Yii::$app->user->logout();
            $this->signInRedirect();

            return false;
        }

        return parent::beforeAction($action);
    }

    protected function isValidUser($user)
    {
        return $user != null;
    }

    abstract public function signInRedirect();
}
