<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\UserPaidGood;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class PurchasesController extends ApplicationController
{
    public function actionIndex()
    {
        $query = UserPaidGood::find()->where([
                'user_id' => $this->getUser()->id,
            ])->with('good');

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('index', [
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

    public function actionAccess($id)
    {
        $model = $this->findModel($id);

        return $this->render('access', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = UserPaidGood::findOne($id)) !== null
            && $model->isOwner($this->getUser()->id)) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
