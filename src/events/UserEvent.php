<?php
namespace wajox\yii2base\events;

use yii\base\Event;

class UserEvent extends Event
{
    const EVENT_SIGN_IN = 'signedIn';
    const EVENT_SIGN_OUT = 'signedOut';
    const EVENT_SIGN_UP = 'signedUp';

    public $user;
}
