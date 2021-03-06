<?php
namespace wajox\yii2base\modules\payment\controllers;

use wajox\yii2base\modules\payment\models\Bill;

class CallbacksController extends ApplicationController
{
    public function actionIndex(string $method, string $action = 'process', int $id = 0)
    {
        $bill = null;

        if ($id != 0) {
            $bill = $this
                ->getRepository()
                ->find(Bill::className())
                ->byId($id)
                ->one();

            if (!$bill) {
                throw new \Exception('Unknown bill id');
            }
        }

        $paymentMethod = $this
            ->getApp()
            ->systemPaymentSettings
            ->getItem($method);

        $data = $this->getApp()->request->isPost ?
            $this->getApp()->request->post() : $this->getApp()->request->get();

        $params = $paymentMethod->processPayment($action, $data);

        $params['payment_method'] = $paymentMethod;
        $params['action'] = $action;

        if ($bill) {
            $params['bill'] = $bill;
        }

        return $this->render($paymentMethod->getId(), $params);
    }
}
