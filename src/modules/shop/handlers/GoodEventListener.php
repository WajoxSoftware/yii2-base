<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\events\GoodEvent;
use wajox\yii2base\models\UserActionLog;
use wajpx\yii2base\handlers\BaseHandler;

class GoodEventHandler extends BaseHandler
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
