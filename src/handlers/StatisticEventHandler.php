<?php
namespace wajox\yii2base\handlers;

use wajox\yii2base\events\StatisticEvent;
use wajox\yii2base\models\Log;
use wajox\yii2base\models\Statistic;

class StatisticEventHandler extends BaseHandler
{
    public static function created(StatisticEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_VISIT_NEW,
            $event->statistic
        );
    }
}
