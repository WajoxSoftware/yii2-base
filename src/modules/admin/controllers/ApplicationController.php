<?php
namespace wajox\yii2base\modules\admin\controllers;

use yii\filters\AccessControl;

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
                        'roles' => ['admin'],
                    ],

                ],

            ],
        ];
    }

    public function signInRedirect()
    {
        return $this->redirect(['/admin/session']);
    }
}
