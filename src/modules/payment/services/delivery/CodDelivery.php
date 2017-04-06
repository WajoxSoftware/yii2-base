<?php
namespace wajox\yii2base\services\delivery;

class CodDelivery extends BaseDeliveryAbstract
{
    public function processNewOrder($order)
    {
        $bill = $order->bill;
        $bill->payment_method = 'CodPayments';

        if (!$bill->save()) {
            return false;
        }

        return $this->addOrder($order);
    }

    public function addOrder($order)
    {
        return $this->getApp()->orderCodManager->addOrder($order);
    }
}
