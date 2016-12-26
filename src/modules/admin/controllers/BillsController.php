<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Bill;
use wajox\yii2base\models\search\BillSearch;
use yii\web\NotFoundHttpException;

class BillsController extends ApplicationController
{
    public function actionIndex()
    {
        $searchModel = $this->createObject(BillSearch::className());
        $dataProvider = $searchModel->search($this->getApp()->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}