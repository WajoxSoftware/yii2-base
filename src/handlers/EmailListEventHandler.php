<?php
namespace wajox\yii2base\handlers;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\events\EmailListEvent;
use wajox\yii2base\models\Log;

class EmailListEventHandler extends BaseHandler
{
    public static function subscribed(EmailListEvent $event)
    {
        $user = null;

        if ($event->subscribe && $event->subscribe->user_id != 0) {
            $user = $event->subscribe->user;
        }

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_NEW_SUBSCRIBE,
            $event->emailList->id,
            $user
        );
    }

    public static function unsubscribed(EmailListEvent $event)
    {
        $user = null;

        if ($event->subscribe && $event->subscribe->user_id != 0) {
            $user = $event->subscribe->user;
        }
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_UNSUBSCRIBE,
            $event->emailList->id,
            $user
        );
    }
}
