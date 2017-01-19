<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\services\events\types\StatisticEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\models\Statistic;
use wajox\yii2base\services\system\EventsManager;

class StatisticEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager $eventsManager)
    {
        $eventsManager->on(Statistic::className(), StatisticEvent::EVENT_NEW, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_VISIT_NEW, $event->statistic);
        });
    }
}
