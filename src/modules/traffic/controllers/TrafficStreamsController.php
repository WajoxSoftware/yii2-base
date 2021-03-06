<?php
namespace wajox\yii2base\modules\traffic\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\services\traffic\TrafficStreamBuilder;

class TrafficStreamsController extends ApplicationController
{
    public function actionCreate($sourceId, $streamId = 0)
    {
        $request = $this->getApp()->request;
        $modelSource = $this->findModelSource($sourceId);

        try {
            $modelStream = $this->findModel($streamId);
            $modelSource = $modelStream->source;
        } catch (\Exception $e) {
            $modelStream = null;
        }

        $this->requireUserAccess($modelSource->user_id);

        $builder = $this
            ->getBuilder($modelSource, $modelStream)
            ->build();

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
        $builder = $this->getBuilder($model->source, null, $model);
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

    protected function getBuilder($source, $stream = null, $model = null)
    {
        return $this->createObject(
            TrafficStreamBuilder::className(),
            [$source, $stream, $model]
        );
    }

    protected function findModelSource($id)
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

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficStream::className())
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
