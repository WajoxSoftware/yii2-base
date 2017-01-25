<?php
namespace wajox\yii2base\events\handlers;

use wajox\yii2base\models\User;
use wajox\yii2base\services\events\types\UserEvent;
use wajox\yii2base\models\UserActionLog;

class UserEventHandler extends BaseHandler
{
    public static function signedIn(UserEvent $event)
    {
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_SIGN_IN,
            $event->user,
            $event->user
        );
    }


    public static function signedOut($event)
    {
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_SIGN_OUT,
            $event->user,
            $event->user
        );
    }

    public static function signedUp($event)
    {
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_SIGN_UP,
            $event->user,
            $event->user
        );
    }
}
