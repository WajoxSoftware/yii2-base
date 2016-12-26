<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodLetter;
use yii\web\NotFoundHttpException;

class GoodLettersController extends ApplicationController
{
    public function actionCreate($id = 0)
    {
        $modelGood = $id != 0 ? Good::findOne($id) : null;
        $goodId = $modelGood == null ? 0 : $modelGood->id;
        $model = $this->createObject(GoodLetter::className());
        $model->good_id = $goodId;
        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
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
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = GoodLetter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
