<?php
namespace wajox\yii2base\services\system;

use yii\base\Event;
use wajox\yii2base\components\base\Object;

class EventsManager extends Object
{
    public $listeners = [];
    public $eventsMap = [];

    public function __construct(array $params = [])
    {
        $listeners = [];
        $handlers = [];

        if (isset($params['listeners'])) {
            $listeners = $params['listeners'];
        }

        if (isset($params['handlers'])) {
            $handlers = $params['handlers'];
        }

        $this
            ->setListeners($listeners)
            ->setHandlers($handlers);
    }

    /**
     * bind event handler
     * @param  string $className event class name
     * @param  string $typeId event type id
     * @param  mixed $callback callback
     * @return EventsManager
     */
    public function on(string $className, string $typeId, $callback): EventsManager
    {
        Event::on($className, $typeId, $callback);

        return $this;
    }

    public function addListener(string $className, array $params = [])
    {
        $handler = $this->createObject($className, [$params]);
        $handler->bindEvents($this);
    }

    public function trigger(string $className, string $typeId, Event $event): EventsManager
    {
        Event::trigger($className, $typeId, $event);

        return $this;
    }

    protected function setListeners(array $listeners): EventsManager
    {
        $this->listeners = $listeners;

        foreach ($this->listeners as $key => $params) {
            if (!is_numeric($key)) {
                $this->addListener($key, $params);
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

    protected function setHandlers(array $handlers)
    {
        foreach ($handlers as $eventClass => $types) {
            foreach ($types as $typeId => $handlers) {
                foreach ($handlers as $handler) {
                    $this->on($eventClass, $typeId, $handler);
                }
            }
        }

        return $this;
    }
}
