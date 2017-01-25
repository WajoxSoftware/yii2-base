<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\models\Good;
use wajox\yii2base\services\events\types\GoodEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\services\system\EventsManager;

class GoodEventListener extends BaseListenerAbstract
{
    public static function ordered($event)
    {
        \Yii::$app->userActionLogs->log(
        	UserActionLog::TYPE_ID_GOOD_ORDER,
        	$event->good
        );
    }
    
    public static function paid($event)
    {
        \Yii::$app->userActionLogs->log(
        	UserActionLog::TYPE_ID_GOOD_PAY,
        	$event->good
        );
    }
}
