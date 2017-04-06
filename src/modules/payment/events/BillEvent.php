<?php
namespace wajox\yii2base\modules\payment\events;

use yii\base\Event;

class BillEvent extends Event
{
    const EVENT_CREATED = 'created';
    const EVENT_PAID = 'paid';
    const EVENT_CANCELLED = 'cancelled';
    const EVENT_RETURNED = 'returned';

    public $bill;
}
