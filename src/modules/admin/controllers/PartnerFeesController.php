<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\PartnerFee;
use wajox\yii2base\services\partner\PartnerFeeManager;
use yii\web\NotFoundHttpException;

/**
 * GoodPartnerProgramsController implements the CRUD actions for GoodPartnerProgram model.
 */
class PartnerFeesController extends ApplicationController
{
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);

        $this->getPartnerFeeManager()->confirm($model);

        return $this->renderJs('update', ['model' => $model]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);

        $this->getPartnerFeeManager()->cancel($model);

        return $this->renderJs('update', ['model' => $model]);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(PartnerFee::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getPartnerFeeManager()
    {
        return $this->getDependency(PartnerFeeManager::className());
    }
}
