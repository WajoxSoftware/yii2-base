<?php
namespace wajox\yii2base\events\types;

use yii\base\Event;

class EmailListEvent extends Event
{
    const EVENT_SUBSCRIBE = 'subscribe';
    const EVENT_UNSUBSCRIBE = 'unsubscribe';

    public $emailList;
    public $subscribe;
}
