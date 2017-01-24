<?php
namespace wajox\yii2base\modules\payment\controllers\admin;

use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\modules\payment\models\search\BillSearch;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class BillsController extends AdminApplicationController
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
        return $this->findModelById(Bill::className(), $id);
    }
}
