<?php

namespace wajox\yii2base\services\events\types;

use yii\base\Event;

class UserEvent extends Event
{
    const EVENT_SIGN_IN = 'user_sign_in';
    const EVENT_SIGN_OUT = 'user_sign_out';
    const EVENT_SIGN_UP = 'user_sign_up';

    public $user;
}
