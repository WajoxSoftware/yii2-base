<?php

namespace wajox\yii2base\services\delivery;

use wajox\yii2base\services\order\OrderMailSender;
use wajox\yii2base\models\Order;

class EmailDelivery extends BaseDeliveryAbstract
{
    public function processNewOrder($order)
    {
        return true;
    }

    public function processPaidOrder($order)
    {
        return $this->processSendOrder($order);
    }

    public function processSendOrder($order)
    {
        if (!$this->sendMailOrder($order)) {
            return $order->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_UNDELIVERED);
        }

        return $order->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_DELIVERED);
    }

    public function sendMailOrder($order)
    {
        $orderSender = $this->createObject(OrderMailSender::className(), [$order]);

        if (!$orderSender->send()) {
            return false;
        }

        if ($orderSender->haveUnsendGoods()) {
            return false;
        }

        return true;
    }
}
