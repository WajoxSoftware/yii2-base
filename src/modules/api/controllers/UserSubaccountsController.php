<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\UserSubaccount;

class UserSubaccountsController extends ApplicationController
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

    public function actionIndex($query = null, $id = null, $userId = null)
    {
        if ($id != null) {
            return $this->actionView($id);
        }

        if ($userId == null) {
            $userId = $this->getUser()->id;
        }

        $subQuery =  $this
            ->getRepository()
            ->find(UserSubaccount::className())
            ->where([
                'user_id' => $userId,
            ]);

        if ($query != null) {
            $subQuery->andWhere([
                    'like', 'name', $query,
                ]);
        }

        $models = $subQuery->limit(self::LIMIT)
                ->indexBy('id')
                ->all();

        return $this->renderJson('index', ['models' => $models]);
    }

    public function actionView($id)
    {
        $model = $this
            ->getRepository()
            ->find(UserSubaccount::className())
            ->byId($id)
            ->one();

        return $this->renderJson('view', ['model' => $model]);
    }
}
