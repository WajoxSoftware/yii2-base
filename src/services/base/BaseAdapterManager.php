<?php
namespace  wajox\yii2base\services\base;

use wajox\yii2base\components\base\Component;

class BaseAdapterManager extends Component
{
    protected $adapter;

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getAdapter(), $name], $arguments);
    }

    protected function createAdapter($adapterClassName, $adapterParams)
    {
        $adapter = $this->createObject($adapterClassName, [$adapterParams]);

        $this->setAdapter($adapter);
    }

    protected function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }
    protected function getAdapter()
    {
        return $this->adapter;
    }
}
