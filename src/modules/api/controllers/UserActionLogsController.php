<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\UserActionLog;

class UserActionLogsController extends ApplicationController
{
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

    public function actionIndex($ids = [])
    {
        $models = $this
            ->getRepository()
            ->find(UserActionLog::className())
            ->where([
                'id' => $ids,
            ])
            ->all()
            ->indexBy('id');

        return $this->renderJson('index', ['models' => $models]);
    }
}
