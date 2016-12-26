<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Payment;
use wajox\yii2base\models\User;
use yii\web\NotFoundHttpException;

class PartnerPaymentsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $model_user = $this->findModel($id);
        $model = $this->createObject(Payment::className());
        $success = false;
        $request = $this->getApp()->request;

        if ($request->isPost) {
            $model->load($request->post());
            $model->user_id = $model_user->id;
            $model->payment_destination_id = Payment::DESTINATION_ID_PARTNER_FEE;
            $model->created_at = time();

            if ($model_user->updateBalance(-1.0 * $model->sum)) {
                $success = $model->save();
            } else {
                $success = false;
            }
        }

        return $this->renderJs('create', [
            'model' => $model,
            'model_user' => $model_user,
            'success' => $success,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
