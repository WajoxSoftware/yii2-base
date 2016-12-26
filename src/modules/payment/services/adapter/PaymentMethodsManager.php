<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class PaymentMethodsManager
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
            $this->getApp()->systemPaymentsSettings
                ->getItem($method)
                ->attachGood($this->good, $settings);
        }

        return $this;
    }

    public function detachMethods()
    {
        foreach ($this->good->paymentMethods as $method) {
            $this->getApp()->systemPaymentySettings
                ->getItem($method->payment_method)
                ->detachGood($this->good);
        }

        return $this;
    }
}
