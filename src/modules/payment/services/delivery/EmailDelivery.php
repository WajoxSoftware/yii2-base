<?php
namespace wajox\yii2base\modules\payment\services\delivery;

use wajox\yii2base\modules\payment\services\OrderMailSender;
use wajox\yii2base\modules\payment\models\Order;

class EmailDelivery extends BaseDeliveryAbstract
{
    public function processNewOrder($order): bool
    {
        return true;
    }

    public function processPaidOrder($order): bool
    {
        return $this->processSendOrder($order);
    }

    public function processSendOrder($order): bool
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
