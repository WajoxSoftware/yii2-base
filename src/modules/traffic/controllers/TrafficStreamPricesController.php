<?php
namespace wajox\yii2base\modules\traffic\controllers;

use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\TrafficStreamPrice;
use yii\web\NotFoundHttpException;

class TrafficStreamPricesController extends ApplicationController
{
    public function actionCreate($id)
    {
        $modelStream = $this->findModelStream($id);
        $model = $this->createObject(TrafficStreamPrice::className());
        $model->traffic_stream_id = $modelStream->id;

        $request = $this->getApp()->request;
        $success = false;

        $this->requireUserAccess($modelStream->user_id);

        if ($request->isPost) {
            $model->load($request->post());
            $success = $model->save();
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = $this->getApp()->request;
        $success = false;

        $this->requireUserAccess($model->stream->user_id);

        if ($request->isPost) {
            $model->load($request->post());
            $success = $model->save();
        }

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->requireUserAccess($model->stream->user_id);
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = TrafficStreamPrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelStream($id)
    {
        if (($model = TrafficStream::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function requireUserAccess($id)
    {
        if ($this->getUser()->isAdmin) {
            return;
        }

        if ($this->getUser()->id == $id) {
            return true;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
