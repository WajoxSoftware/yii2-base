<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\Good;

class GoodsController extends ApplicationController
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

        $goodQuery =  $this
            ->getRepository()
            ->find(Good::className());

        if ($query != null) {
            $goodQuery->where([
                'like', 'title', $query,
            ]);
        }

        $models = $goodQuery
            ->limit(self::LIMIT)
            ->indexBy('id')
            ->all();

        return $this->renderJson('index', ['models' => $models]);
    }

    public function actionView($id)
    {
        $model = $this
            ->getRepository()
            ->find(Good::className($id));

        return $this->renderJson('view', ['model' => $model]);
    }
}
