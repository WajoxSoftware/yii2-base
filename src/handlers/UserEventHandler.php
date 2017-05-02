<?php
namespace wajox\yii2base\handlers;

use wajox\yii2base\models\User;
use wajox\yii2base\events\UserEvent;
use wajox\yii2base\models\Log;

class UserEventHandler extends BaseHandler
{
    public static function signedIn(UserEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_SIGN_IN,
            $event->user,
            $event->user
        );
    }

    public static function signedOut($event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_SIGN_OUT,
            $event->user,
            $event->user
        );
    }

    public static function signedUp($event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_SIGN_UP,
            $event->user->id,
            $event->user
        );
    }
}
