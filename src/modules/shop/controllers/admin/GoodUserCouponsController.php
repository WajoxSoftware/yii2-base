<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodUserCoupon;
use wajox\yii2base\modules\shop\models\form\GoodUserCouponForm;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class GoodUserCouponsController extends AdminApplicationController
{
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id, $typeId)
    {
        $model_good = $this->findGoodModel($id);

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
        return $this->findModelById(GoodUserCoupon::className(), $id);
    }

    protected function findGoodModel($id)
    {
        return $this->findModelById(Good::className(), $id);
    }
}
