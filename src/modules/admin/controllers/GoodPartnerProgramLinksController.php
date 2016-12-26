<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodPartnerProgramLink;
use yii\web\NotFoundHttpException;

class GoodPartnerProgramLinksController extends ApplicationController
{
    public function actionCreate($id)
    {
        $modelGood = Good::findOne($id);
        $model = $this->createObject(GoodPartnerProgramLink::className());
        $model->good_partner_program_id = $modelGood->partnerProgram->id;
        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
        }

        return $this->renderJs('create', [
            'model' => $model,
            'modelGood' => $modelGood,
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
        if (($model = GoodPartnerProgramLink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
