<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shopmodels\EGoodEntity;
use wajox\yii2base\models\UploadedFile;
use wajox\yii2base\services\uploads\UploadsManager;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class EgoodEntitiesController extends AdminApplicationController
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
        return $this->findModelById(EGoodEntity::className(), $id);
    }

    protected function findGoodModel($id)
    {
        return $this->findModelById(Good::className(), $id);
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
        return $this->createObject(
            UploadsManager::className(),
            [$this->getUser()]
        );
    }
}
