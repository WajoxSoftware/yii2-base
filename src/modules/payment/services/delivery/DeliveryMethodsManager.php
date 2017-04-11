<?php
namespace wajox\yii2base\modules\payment\services\delivery;

use wajox\yii2base\components\base\Object;

class DeliveryMethodsManager extends Object
{
    public $good = null;

    public function __construct($good)
    {
        $this->setGood($good);
    }

    public function setGood($good)
    {
        $this->good = $good;

        return $this;
    }

    public function attachMethods($methods)
    {
        foreach ($methods as $method => $settings) {
            $this->getApp()->systemDeliverySettings
                ->getItem($method)
                ->attachGood($this->good, $settings);
        }

        return $this;
    }

    public function detachMethods()
    {
        foreach ($this->good->deliveryMethods as $method) {
            $this->getApp()->systemDeliverySettings
                ->getItem($method->delivery_method)
                ->detachGood($this->good);
        }

        return $this;
    }
}
