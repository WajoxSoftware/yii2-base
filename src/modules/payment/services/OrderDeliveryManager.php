<?php
namespace wajox\yii2base\modules\payment\services;

use wajox\yii2base\components\base\Object;

class OrderDeliveryManager extends Object
{
    public function processNewOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processPaidOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processCancelledOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processMoneyReturnedOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processPreparedOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processSendOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processDeliveredOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processUndeliveredOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function processReturnedOrder($order)
    {
        return $this->callAdapter($order, __FUNCTION__);
    }

    public function callAdapter($order, $callbackName)
    {
        $class = 'wajox\yii2base\modules\payment\services\delivery\\' . $order->delivery_method;
        $obj = $this->createObject($class);

        return $obj->$callbackName($order);
    }
}
