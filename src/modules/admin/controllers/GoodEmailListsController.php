<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodEmailList;
use wajox\yii2base\models\EmailList;
use yii\web\NotFoundHttpException;

class GoodEmailListsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $model_good = Good::findOne($id);
        $model = $this->createObject(GoodEmailList::className());
        $model->good_id = $model_good->id;
        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findEmailListModel($id)
    {
        if (($model = EmailList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = GoodEmailList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
