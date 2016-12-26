<?php
namespace wajox\yii2base\services\events\handlers;

abstract class EventHandlerAbstract
{
    protected $params = [];

    public function __construct($params = [])
    {
        $this->setParams($params);
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    abstract public function bindEvents($eventsManager);
}
