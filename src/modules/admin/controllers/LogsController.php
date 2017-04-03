<?php

namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Log;
use wajox\yii2base\models\search\LogSearch;
use yii\web\NotFoundHttpException;

class LogsController extends ApplicationController
{
    public function actionIndex()
    {
        $searchModel = $this->createObject(LogSearch::className());
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
        return $this->findModelById(
            Log::className(),
            $id
        );
    }
}
