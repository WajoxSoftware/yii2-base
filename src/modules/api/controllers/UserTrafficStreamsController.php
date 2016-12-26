<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\TrafficStream;

class UserTrafficStreamsController extends ApplicationController
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
                        'roles' => ['partner'],
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

        $tsQuery =  TrafficStream::find()->where([
                'user_id' => $this->getUser()->id,
            ]);

        if ($query != null) {
            $tsQuery->andWhere([
                    'like', 'title', $query,
                ]);
        }

        $models = $tsQuery->limit(self::LIMIT)
                ->indexBy('id')
                ->all();

        return $this->renderJson('index', ['models' => $models]);
    }

    public function actionView($id)
    {
        $model = TrafficStream::findOne($id);

        return $this->renderJson('view', ['model' => $model]);
    }
}
