<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodPartnerProgramLink;
use wajox\yii2base\modules\admin\controllers\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class GoodPartnerProgramLinksController extends AdminApplicationController
{
    public function actionCreate($id)
    {
        $modelGood = $this->findGoodModel($id);
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
        return $this->findModelById(
            GoodPartnerProgramLink::className(),
            $id
        );
    }

    protected function findGoodModel($id)
    {
        return $this->findModelById(Good::className(), $id);
    }
}
