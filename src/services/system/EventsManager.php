<?php
namespace wajox\yii2base\services\system;

use yii\base\Event;
use wajox\yii2base\components\base\Object;

class EventsManager extends Object
{
    public $handlers = [];

    public function __construct($params = [])
    {
        if (isset($params['handlers'])) {
            $this->setHandlers($params['handlers']);
        }
    }

    public function on($className, $typeId, $callback)
    {
        Event::on($className, $typeId, $callback);

        return $this;
    }

    public function addHandler($className, $params = [])
    {
        $handler = $this->createObject($className, [$params]);
        $handler->bindEvents($this);
    }

    public function trigger($className, $typeId, $event)
    {
        Event::trigger($className, $typeId, $event);

        return $this;
    }

    protected function setHandlers($handlers)
    {
        $this->handlers = $handlers;

        foreach ($this->handlers as $key => $params) {
            if (!is_numeric($key)) {
                $this->addHandler($key, $params);
                continue;
            }

            $this->on(
                $params[0],
                $params[1],
                $params[2]
            );
        }

        return $this;
    }
}
