<?php

namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\search\UserActionLogSearch;
use yii\web\NotFoundHttpException;

class UserActionLogsController extends ApplicationController
{
    public function actionIndex()
    {
        $searchModel = $this->createObject(UserActionLogSearch::className());
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
            UserActionLog::className(),
            $id
        );
    }
}
