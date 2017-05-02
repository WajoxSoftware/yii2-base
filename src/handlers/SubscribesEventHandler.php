<?php
namespace wajox\yii2base\handlers;

use wajox\yii2base\services\subscribes\SubscribesManager;

class SubscribesEventHandler extends BaseHandler
{
    public static function orderCreated($event)
    {
        SubscribesManager::subscribeOrder($event->order);
    }
}
