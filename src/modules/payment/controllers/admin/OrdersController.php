<?php

namespace wajox\yii2base\modules\payment\controllers;

use wajox\yii2base\models\Order;
use wajox\yii2base\models\search\OrderSearch;
use yii\web\NotFoundHttpException;
use yii\data\Sort;

class OrdersController extends AdminApplicationController
{
    public function actionIndex()
    {
        $sort = $this->getSort();
        $searchModel = $this->createObject(OrderSearch::className());
        $dataProvider = $searchModel->search($this->getApp()->request->queryParams, $sort);

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

        if ($request->isPost
            && $model->load($request->post())
            && $model->save()
        ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function getSort()
    {
        return $this->createObject(Sort::className(), [[
            'attributes' => [
                'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                'status_id' => ['label' => \Yii::t('app/attributes', 'Status')],
                'delivery_status_id' => ['label' => \Yii::t('app/attributes', 'Delivery Status')],
                'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],
                'status_at' => ['label' => \Yii::t('app/attributes', 'Status At')],
                'sum' => ['label' => \Yii::t('app/attributes', 'Sum')],
            ],
        ]]);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(Order::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
