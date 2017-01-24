<?php

namespace wajox\yii2base\services\shop;

use wajox\yii2base\components\base\Component;

class SystemDeliverySettings extends Component
{
    public $settings = [];
    public $items = [];

    public function __construct($params = [])
    {
        $this->settings = $params['settings'];
        foreach ($this->settings as $className => $options) {
            $fullClassName = 'wajox\yii2base\services\delivery\\' . $className;
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

    public function isEnabled($system)
    {
        if ($this->get($system) == null) {
            return false;
        }

        return true;
    }

    public function getActiveItems()
    {
        return array_keys($this->items);
    }
}
