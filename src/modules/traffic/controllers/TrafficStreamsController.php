<?php
namespace wajox\yii2base\modules\traffic\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\services\traffic\TrafficStreamBuilder;

class TrafficStreamsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $request = $this->getApp()->request;
        $modelSource = $this->findModelSource($id);

        $this->requireUserAccess($modelSource->user_id);

        if ($modelSource->hasSources) {
            throw new NotFoundHttpException('Error');
        }

        $builder = $this->getBuilder($modelSource)->build();
        $success = false;

        if ($request->isPost) {
            $success = $builder->save($request);
        }

        return $this->renderJs('create', [
            'builder' => $builder,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);
        $builder = $this->getBuilder($model->source, $model);
        $success = false;

        $this->requireUserAccess($model->user_id);

        if ($request->isPost) {
            $success = $builder->save($request);
        }

        return $this->renderJs('update', [
            'builder' => $builder,
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

    protected function getBuilder($source, $model = null)
    {
        return $this->createObject(TrafficStreamBuilder::className(), $source, $model);
    }

    protected function findModelSource($id)
    {
        if (($model = TrafficSource::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
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
