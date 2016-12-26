<?php
namespace wajox\yii2base\services\events\handlers;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\services\events\types\EmailListEvent;
use wajox\yii2base\models\UserActionLog;

class EmailListEventHandler extends EventHandlerAbstract
{
    public function bindEvents($eventsManager)
    {
        $eventsManager->on(EmailList::className(), EmailListEvent::EVENT_SUBSCRIBE, function ($event) {
            $user = null;

            if ($event->subscribe && $event->subscribe->user_id != 0) {
                $user = $event->subscribe->user;
            }

            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_NEW_SUBSCRIBE, $event->emailList, $user);
        });

        $eventsManager->on(EmailList::className(), EmailListEvent::EVENT_UNSUBSCRIBE, function ($event) {
            $user = null;

            if ($event->subscribe && $event->subscribe->user_id != 0) {
                $user = $event->subscribe->user;
            }
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_UNSUBSCRIBE, $event->emailList, $user);
        });
    }
}
