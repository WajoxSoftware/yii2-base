<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\models\MessageUserStatus;
use wajox\yii2base\services\events\types\MessageUserStatusEvent;
use wajox\yii2base\services\notifications\UserNotificationsManager;
use wajox\yii2base\services\system\EventsManager;

class MessageUserStatusEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager$eventsManager)
    {
        $eventsManager->on(MessageUserStatus::className(), MessageUserStatusEvent::EVENT_CREATED, function ($event) {
            (new UserNotificationsManager($event->messageUserStatus->user))->messageStatusNotification($event->messageUserStatus);
        });

        $eventsManager->on(MessageUserStatus::className(), MessageUserStatusEvent::EVENT_READ, function ($event) {
            ;
        });

        $eventsManager->on(MessageUserStatus::className(), MessageUserStatusEvent::EVENT_DELETED, function ($event) {
            ;
        });
    }
}
