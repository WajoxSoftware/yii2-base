<?php
namespace wajox\yii2base\handlers;

use wajox\yii2base\services\events\StatisticEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\Statistic;

class StatisticEventHandler extends BaseHandler
{
    public static function created(StatisticEvent $event)
    {
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_VISIT_NEW,
            $event->statistic
        );
    }
}
