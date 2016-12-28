<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\TrafficManager;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\users\TrafficManagersBuilder;

class TrafficManagersController extends ApplicationController
{
    public function actionCreate()
    {
        $user = $this->createObject(User::className());
        $model = $this->createObject(TrafficManager::className());
        $request = $this->getApp()->request;
        $builder = $this->createObject(
            TrafficManagersBuilder::className(),
            [$user, $model]
        );

        if ($request->isPost && $builder->save($request)) {
            return $this->redirect([
                '/admin/traffics/view-user',
                'id' => $builder->getModel()->user_id,
            ]);
        }
        return $this->render('create', [
            'model' => $builder->getModel(),
            'modelUser' => $builder->getUser(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = $model->user;
        $request = $this->getApp()->request;
        $builder = $this->createObject(
            TrafficManagersBuilder::className(),
            [$user, $model]
        );

        if ($request->isPost && $builder->save($request)) {
            return $this->redirect([
                'view',
                'id' => $builder->getModel()->id,
            ]);
        }

        return $this->render('update', [
            'model' => $builder->getModel(),
            'modelUser' => $builder->getUser(),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficManager::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
