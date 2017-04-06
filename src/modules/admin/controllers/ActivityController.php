<?php
namespace wajox\yii2base\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Log;
use wajox\yii2base\models\search\LogSearch;
use yii\web\NotFoundHttpException;

class ActivityController extends ApplicationController
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

        $query = $this
            ->getRepository()
            ->find(Log::className())
            ->byUserIdOrGuid($model->user_id, $model->guid)
            ->orderBy('id DESC');

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
        $model = $this
            ->getRepository()
            ->find(Log::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
