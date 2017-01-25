<?php
namespace wajox\yii2base\events\handlers;

use wajox\yii2base\models\MessageUserStatus;
use wajox\yii2base\services\events\types\MessageUserStatusEvent;
use wajox\yii2base\services\notifications\UserNotificationsManager;

class MessageUserStatusEventHandler extends BaseHandler
{
    public static function created(MessageUserStatusEvent $event)
    {
        (new UserNotificationsManager($event->messageUserStatus->user))->messageStatusNotification($event->messageUserStatus);
    }
}
