<?php
namespace wajox\yii2base\modules\shop\events;

use yii\base\Event;

class GoodEvent extends Event
{
    const EVENT_ORDERED = 'ordered';
    const EVENT_PAID = 'paid';

    public $good;
}
