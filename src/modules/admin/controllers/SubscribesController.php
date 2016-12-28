<?php

namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Subscribe;
use wajox\yii2base\models\search\SubscribeSearch;
use yii\web\NotFoundHttpException;
use yii\data\Sort;

class SubscribesController extends ApplicationController
{
    public function actionIndex()
    {
        $sort = $this->getSort();
        $searchModel = $this->createObject(SubscribeSearch::className());
        $params = $this->getApp()->request->queryParams;
        $dataProvider = $searchModel->search($params, $sort);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
        ]);
    }

    public function actionView($id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [[
                'query' => $model->getUserActionLogs(),
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ],
                ],
            ]]
        );

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    protected function getSort()
    {
        return $this->createObject(
            Sort::className(),
            [[
                'attributes' => [
                    'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                    'email' => ['label' => \Yii::t('app/attributes', 'Email')],
                    'phone' => ['label' => \Yii::t('app/attributes', 'Phone')],
                    'name' => ['label' => \Yii::t('app/attributes', 'Name')],
                    'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],

                ],
            ]]
        );
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(Subscribe::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
