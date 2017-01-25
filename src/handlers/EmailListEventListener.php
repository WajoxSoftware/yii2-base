<?php
namespace wajox\yii2base\events;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\events\EmailListEvent;
use wajox\yii2base\models\UserActionLog;

class EmailListEventHandler extends BaseHandler
{
    public static function subscribed(EmailListEvent $event)
    {
        $user = null;

        if ($event->subscribe && $event->subscribe->user_id != 0) {
            $user = $event->subscribe->user;
        }

        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_NEW_SUBSCRIBE,
            $event->emailList,
            $user
        );
    }

    public static function unsubscribed(EmailListEvent $event)
    {
        $user = null;

        if ($event->subscribe && $event->subscribe->user_id != 0) {
            $user = $event->subscribe->user;
        }
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_UNSUBSCRIBE,
            $event->emailList,
            $user
        );
    }
}
