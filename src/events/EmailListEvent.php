<?php
namespace wajox\yii2base\events;

use yii\base\Event;

/**
 * Event class for EmailList class
 */
class EmailListEvent extends Event
{
    const EVENT_SUBSCRIBE = 'subscribed';
    const EVENT_UNSUBSCRIBE = 'unsubscribed';

    public $emailList;
    public $subscribe;
}
