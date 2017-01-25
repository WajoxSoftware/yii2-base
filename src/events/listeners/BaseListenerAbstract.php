<?php
namespace wajox\yii2base\events\listeners;

use wajox\yii2base\services\system\EventsManager;

abstract class BaseListenerAbstract
{
    protected $params = [];

    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

    public function setParams(array $params): BaseListenerAbstract
    {
        $this->params = $params;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    abstract public function bindEvents(EventsManager $eventsManager);
}
