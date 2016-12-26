<?php
namespace wajox\yii2base\services\events\handlers;

use wajox\yii2base\services\events\types\StatisticEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\Statistic;

class StatisticEventHandler extends EventHandlerAbstract
{
    public function bindEvents($eventsManager)
    {
        $eventsManager->on(Statistic::className(), StatisticEvent::EVENT_NEW, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_VISIT_NEW, $event->statistic);
        });
    }
}
