<?php
namespace wajox\yii2base\modules\traffic\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\TrafficSource;
use yii\web\NotFoundHttpException;

class TrafficSourcesController extends ApplicationController
{
    public function actionCreate($id, $parentId = 0)
    {
        $userId = $this->findModelUser($id)->id;

        if ($parentId != 0) {
            $parentSource = $this->findModel($parentId);

            if ($parentSource->hasStreams
                || $parentSource->user_id != $userId
            ) {
                throw new NotFoundHttpException('Error');
            }

            $parentId = $parentSource->id;
            $userId = $parentSource->user_id;
        }

        $this->requireUserAccess($userId);

        $model = $this->createObject(TrafficSource::className());
        $model->user_id = $userId;
        $model->parent_source_id = $parentId;
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = $this->getApp()->request;
        $success = false;

        $this->requireUserAccess($model->user_id);

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
        }

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $this->requireUserAccess($model->user_id);

        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findModelUser($id)
    {
        $model = $this
            ->getRepository()
            ->find(User::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficSource::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
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
