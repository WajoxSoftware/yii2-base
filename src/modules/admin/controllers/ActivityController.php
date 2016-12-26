<?php

namespace wajox\yii2base\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\search\UserActionLogSearch;
use yii\web\NotFoundHttpException;

class ActivityController extends ApplicationController
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

        $query = UserActionLog::find()->where([
                'user_id' => $model->user_id,
            ])->orWhere([
                'guid' => $model->guid,
            ])->orderBy('id DESC');

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserActionLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
