<?php
namespace wajox\yii2base\services\events\types;

use yii\base\Event;

class OrderEvent extends Event
{
    const EVENT_CREATED = 'order created';
    const EVENT_PAID = 'order paid';
    const EVENT_CANCELLED = 'order cancelled';
    const EVENT_MONEY_RETURNED = 'order money returned';

    const EVENT_PREPARED = 'order prepared';
    const EVENT_SEND = 'order send';
    const EVENT_DELIVERED = 'order delivered';
    const EVENT_UNDELIVERED = 'order_undelivered';
    const EVENT_RETURNED = 'order returned';

    public $order;
}
