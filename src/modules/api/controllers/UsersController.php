<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\User;

class UsersController extends ApplicationController
{
    const LIMIT = 30;

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

    public function actionIndex($query = null, $id = null)
    {
        if ($id != null) {
            return $this->actionView($id);
        }

        $userQuery =  User::find();

        if ($query != null) {
            $userQuery->where([
                    'like', 'name', $query,
                ]);
        }

        $models = $userQuery->limit(self::LIMIT)
                ->indexBy('id')
                ->all();

        return $this->renderJson('index', ['models' => $models]);
    }

    public function actionView($id)
    {
        $model = User::findOne($id);

        return $this->renderJson('view', ['model' => $model]);
    }
}
