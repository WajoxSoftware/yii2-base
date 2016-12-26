<?php

namespace wajox\yii2base\services\events\types;

use yii\base\Event;

class GoodEvent extends Event
{
    const EVENT_ORDERED = 'good order created';
    const EVENT_PAID = 'good order paid';

    public $good;
}
