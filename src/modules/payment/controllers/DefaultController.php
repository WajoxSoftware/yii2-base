<?php
namespace wajox\yii2base\modules\payment\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\models\Bill;

class DefaultController extends ApplicationController
{
    public function actionIndex($id)
    {
        $bill = $this->findBill($id);
        $isCashMethod = $this
            ->getApp()
            ->systemPaymentSettings
            ->isCashMethod($bill->payment_method);

        if ($isCashMethod) {
            return $this->redirect([
                '/payment/callbacks',
                'method' => $bill->payment_method,
                'action' => 'waiting',
                'id' => $bill->id,
            ]);
        }

        return $this->render('index', ['bill' => $bill]);
    }

    public function actionStatus($id)
    {
        $bill = $this->findBill($id);

        return $this->render('status', ['bill' => $bill]);
    }

    private function findBill($id)
    {
        return $this->findModelById(Bill::className(), $id);
    }
}
