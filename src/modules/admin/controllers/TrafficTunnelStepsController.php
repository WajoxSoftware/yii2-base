<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\TrafficTunnel;
use wajox\yii2base\models\TrafficTunnelStep;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class TrafficTunnelStepsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $request = $this->getApp()->request;
        $tunnelModel = $this->findTunnelModel($id);
        $model = $this->createObject(TrafficTunnelStep::className());
        $model->traffic_tunnel_id = $tunnelModel->id;
        $success = false;

        if ($request->isPost
            &&  $model->load($request->post())
        ) {
           $success = $model->save();
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);
        $success = false;

        if ($request->isPost
            && $model->load($request->post())
        ) {
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
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficTunnelStep::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findTunnelModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficTunnel::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
