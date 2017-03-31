<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shopmodels\GoodLetter;
use wajox\yii2base\modules\admin\controllers\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class GoodLettersController extends AdminApplicationController
{
    public function actionCreate($id = 0)
    {
        $modelGood = $id != 0 ? $this->findGoodModel($id) : null;
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

    protected function findGoodModel($id)
    {
        return $this->findModelById(Good::className(), $id);
    }

    protected function findModel($id)
    {
        return $this->findModelById(GoodLetter::className(), $id);
    }
}
