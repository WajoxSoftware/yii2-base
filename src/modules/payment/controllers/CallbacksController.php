<?php
namespace wajox\yii2base\modules\payment\controllers;

use wajox\yii2base\models\Bill;

class CallbacksController extends ApplicationController
{
    public function actionIndex($method, $action = 'process', $id = 0)
    {
        $bill = $id == 0 ? null : Bill::findOne($id);

        $paymentMethod = $this->getApp()->systemPaymentSettings->getItem($method);
        $data = $this->getApp()->request->isPost ? $this->getApp()->request->post() : null;

        $params = $paymentMethod->processPayment($action, $data);

        $params['payment_method'] = $paymentMethod;
        $params['action'] = $action;
        $params['bill'] = $bill;

        return $this->render($paymentMethod->getId(), $params);
    }
}
