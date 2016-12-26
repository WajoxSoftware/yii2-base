<?php
namespace wajox\yii2base\modules\traffic\controllers;

use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\TrafficStreamImage;
use wajox\yii2base\models\UploadedImage;
use wajox\yii2base\services\uploads\UploadsManager;
use yii\web\NotFoundHttpException;

class TrafficStreamImagesController extends ApplicationController
{
    public function actionCreate($id)
    {
        $request = $this->getApp()->request;
        $success = false;

        $stream = $this->findStream($id);
        $model = $this->createObject(UploadedImage::className());
        $streamImage = $this->createObject(TrafficStreamImage::className());

        $this->requireUserAccess($stream->user_id);

        if ($request->isPost) {
            $manager = $this->getUploadsManager()
            $model = $manager->saveImage($request);

            if (!$model->isNewRecord) {
                $streamImage = $this->createObject(TrafficStreamImage::className());
                $streamImage->uploaded_image_id = $model->id;
                $streamImage->traffic_stream_id = $stream->id;

                if ($streamImage->save()) {
                    $manager->show($model->id);
                    $success = true;
                }
            }
        }

        return $this->renderJs('create', [
            'model' => $model,
            'streamImage' => $streamImage,
            'stream' => $stream,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $manager = $this->getUploadsmanager();
        $manager->remove($model->uploaded_image_id);
        $model->delete();

        $this->requireUserAccess($model->stream->user_id);

        return $this->renderJs('delete', ['model' => $model]);
    }

    protected function findStream($id)
    {
        if (($model = TrafficStream::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
        if (($model = TrafficStreamImage::findOne($id)) !== null) {
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

    protected function getUploadsManager()
    {
        return $this->createObject(UploadsManager::className(), [$this->getUser()]);
    }
}
