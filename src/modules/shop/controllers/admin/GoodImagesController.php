<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodImage;
use wajox\yii2base\models\UploadedImage;
use wajox\yii2base\services\uploads\UploadsManager;
use yii\web\NotFoundHttpException;

class GoodImagesController extends ApplicationController
{
    public function actionCreate($id)
    {
        $request = $this->getApp()->request;
        $success = false;

        $user = $this->getUser();
        $good = $this->findGood($id);
        $model = $this->createObject(UploadedImage::className());
        $goodImage = $this->createObject(GoodImage::className());

        if ($request->isPost) {
            $manager = $this->getUploadsManager();
            $model = $manager->saveImage($request);

            if (!$model->isNewRecord) {
                $goodImage = $this->createObject(GoodImage::className());
                $goodImage->uploaded_image_id = $model->id;
                $goodImage->good_id = $good->id;

                if ($goodImage->save()) {
                    $manager->show($model->id);
                    $success = true;
                }
            }
        }

        return $this->renderJs('create', [
            'model' => $model,
            'goodImage' => $goodImage,
            'good' => $good,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->getUploadsManager()->remove($model->uploaded_image_id);
        $model->delete();

        return $this->renderJs('delete', ['model' => $model]);
    }

    protected function findGood($id)
    {
        return $this->findModelById(Good::className(), $id);
    }

    protected function findModel($id)
    {
        return $this->findModelById(GoodImage::className(), $id);
    }

    protected function getUploadsManager()
    {
        return $this->createObject(UploadsManager::className(), [$this->getUser()]);
    }
}
