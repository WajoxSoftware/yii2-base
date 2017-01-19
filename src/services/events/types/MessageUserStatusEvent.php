<?php
namespace wajox\yii2base\services\events\types;

use yii\base\Event;

class MessageUserStatusEvent extends Event
{
    const EVENT_CREATED = 'message status created';
    const EVENT_READ = 'message status read';
    const EVENT_DELETED = 'message status deleted';

    public $messageUserStatus;
}
