<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodUserCoupon;
use wajox\yii2base\models\form\GoodUserCouponForm;
use yii\web\NotFoundHttpException;

class GoodUserCouponsController extends ApplicationController
{
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id, $typeId)
    {
        $model_good = Good::findOne($id);

        $modelCoupon = $this->createObject(GoodUserCoupon::className());
        $modelCoupon->type_id = $typeId;
        $modelCoupon->good_id = $model_good->id;
        $modelCoupon->created_at = time();

        $model = $this->createObject(GoodUserCouponForm::className());
        $model->setModel($modelCoupon);

        $request = $this->getApp()->request;

        $success = false;

        if ($request->isPost
            && $model->load($request->post())
            && $model->validate()
        ) {
            $success = $model->saveModel();
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $modelCoupon = $this->findModel($id);
        $request = $this->getApp()->request;

        $model = $this->createObject(GoodUserCouponForm::className());
        $model->setModel($modelCoupon);

        $success = false;

        if ($request->isPost
            && $model->load($request->post())
            && $model->validate()
        ) {
            $success = $model->saveModel();
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
        if (($model = GoodUserCoupon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
