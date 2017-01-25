<?php
namespace wajox\yii2base\events;

use yii\base\Event;

class UserEvent extends Event
{
    const EVENT_SIGN_IN = 'signed in';
    const EVENT_SIGN_OUT = 'signed out';
    const EVENT_SIGN_UP = 'signed up';

    public $user;
}
