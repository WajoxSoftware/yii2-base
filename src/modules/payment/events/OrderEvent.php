<?php
namespace wajox\yii2base\services\events\types;

use yii\base\Event;

class OrderEvent extends Event
{
    const EVENT_CREATED = 'created';
    const EVENT_PAID = 'paid';
    const EVENT_CANCELLED = 'cancelled';
    const EVENT_MONEY_RETURNED = 'moneyReturned';

    const EVENT_PREPARED = 'prepared';
    const EVENT_SEND = 'send';
    const EVENT_DELIVERED = 'delivered';
    const EVENT_UNDELIVERED = 'undelivered';
    const EVENT_RETURNED = 'returned';

    public $order;
}
