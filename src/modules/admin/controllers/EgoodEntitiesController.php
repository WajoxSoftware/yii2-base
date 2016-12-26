<?php
namespace wajox\yii2base\modules\admin\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\models\Good;
use wajox\yii2base\models\EGoodEntity;
use wajox\yii2base\models\UploadedFile;
use wajox\yii2base\services\uploads\UploadsManager;

class EgoodEntitiesController extends ApplicationController
{
    public function actionCreate($id, $typeId)
    {
        $modelGood = $this->findGoodModel($id);
        $goodId = $modelGood->id;
        $model = $this->createObject(EGoodEntity::className());
        $model->good_id = $goodId;
        $model->type_id = $typeId;

        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $file = $this->getUploadedFile();
            $model->load($request->post());
            $model->file_id = $file->id;
            if ($model->save()) {
                $this->approveFile($file);
                $success = true;
            }
        }

        return $this->renderJs('create', [
            'modelGood' => $modelGood,
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $file = $this->getUploadedFile();
            $model->load($request->post());
            $model->file_id = $file->id;
            if ($model->save()) {
                $this->approveFile($file);
                $success = true;
            }
        }

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->uploadedFile) {
            $model->uploadedFile->delete();
        }

        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = EGoodEntity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findGoodModel($id)
    {
        if (($model = Good::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getUploadedFile()
    {
        $request = $this->getApp()->request;
        $model = $this->createObject(UploadedFile::className());

        if ($request->isPost) {
            $model = $this->getUploadsManager()->save($request);
        }

        return $model;
    }

    protected function approveFile($file)
    {
        $this->getUploadsManager()->show($file->id);
    }

    protected function getUploadsManager()
    {
         return $this->createObject(UploadsManager::className(), [$this->getUser()])
    }
}
