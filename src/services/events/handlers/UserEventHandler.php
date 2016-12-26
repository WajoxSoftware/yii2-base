<?php
namespace wajox\yii2base\services\events\handlers;

use wajox\yii2base\models\User;
use wajox\yii2base\services\events\types\UserEvent;
use wajox\yii2base\models\UserActionLog;

class UserEventHandler extends EventHandlerAbstract
{
    public function bindEvents($eventsManager)
    {
        $eventsManager->on(User::className(), UserEvent::EVENT_SIGN_IN, function ($event) {
           \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_SIGN_IN, $event->user, $event->user);
        });

        $eventsManager->on(User::className(), UserEvent::EVENT_SIGN_OUT, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_SIGN_OUT, $event->user, $event->user);
        });

        $eventsManager->on(User::className(), UserEvent::EVENT_SIGN_UP, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_SIGN_UP, $event->user, $event->user);
        });
    }
}
