<?php
namespace wajox\yii2base\modules\traffic\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\User;

class ApplicationController extends \wajox\yii2base\controllers\AuthenticatedController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_PARTNER,
                            User::ROLE_MANAGER,
                            User::ROLE_ADMIN,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function signInRedirect()
    {
        throw new \Exception('Forbidden');
    }
}
