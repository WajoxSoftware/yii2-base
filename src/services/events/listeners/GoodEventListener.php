<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\models\Good;
use wajox\yii2base\services\events\types\GoodEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\services\system\EventsManager;

class GoodEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager $eventsManager)
    {
        $eventsManager->on(Good::className(), GoodEvent::EVENT_ORDERED, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_GOOD_ORDER, $event->good);
        });
        
        $eventsManager->on(Good::className(), GoodEvent::EVENT_PAID, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_GOOD_PAY, $event->good);
        });
    }
}
