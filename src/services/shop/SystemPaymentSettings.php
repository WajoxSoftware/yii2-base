<?php
namespace wajox\yii2base\services\shop;

use wajox\yii2base\components\base\Component;

class SystemPaymentSettings extends Component
{
    public $settings = [];
    public $items = [];
    public $cashPaymentMethods = [];

    public function __construct($params = [])
    {
        $this->settings = $params['settings'];
        $this->cashPaymentMethods = $params['cashPaymentMethods'];
        foreach ($this->settings as $className => $options) {
            $fullClassName = 'wajox\yii2base\modules\payment\services\adapter\\'.$className;
            $this->items[$className] = $this->createObject($fullClassName);
        }
    }

    public function getSettings($item)
    {
        if (isset($this->settings[$item])) {
            return $this->settings[$item];
        }

        return;
    }

    public function getItem($item)
    {
        if (isset($this->items[$item])) {
            return $this->items[$item];
        }

        return;
    }

    public function isCashMethod($system)
    {
        return in_array($system, $this->cashPaymentMethods);
    }

    public function isEnabled($system)
    {
        if ($this->get($system) == null) {
            return false;
        }

        return true;
    }

    public function getCachPaymentMethods()
    {
        return $this->cashPaymentMethods;
    }

    public function getActiveItems($onlyCash = false)
    {
        $activeItems = $onlyCash ? $this->cashPaymentMethods : array_keys($this->items);

        return $activeItems;
    }
}
