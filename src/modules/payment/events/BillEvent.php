<?php
namespace wajox\yii2base\modules\payment\events;

use yii\base\Event;

class BillEvent extends Event
{
    const EVENT_CREATED = 'bill created';
    const EVENT_PAID = 'bill paid';
    const EVENT_CANCELLED = 'bill cancelled';
    const EVENT_RETURNED = 'bill returned';

    public $bill;
}