<?php
namespace wajox\yii2base\events;

use yii\base\Event;

class MessageUserStatusEvent extends Event
{
    const EVENT_CREATED = 'created';
    const EVENT_READ = 'read';
    const EVENT_DELETED = 'deleted';

    public $messageUserStatus;
}
