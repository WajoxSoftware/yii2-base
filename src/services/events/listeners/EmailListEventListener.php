<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\services\events\types\EmailListEvent;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\services\system\EventsManager;

class EmailListEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager $eventsManager)
    {
        $eventsManager->on(EmailList::className(), EmailListEvent::EVENT_SUBSCRIBE, function ($event) {
            $user = null;

            if ($event->subscribe && $event->subscribe->user_id != 0) {
                $user = $event->subscribe->user;
            }

            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_NEW_SUBSCRIBE, $event->emailList, $user);
        });

        $eventsManager->on(EmailList::className(), EmailListEvent::EVENT_UNSUBSCRIBE, function ($event) {
            $user = null;

            if ($event->subscribe && $event->subscribe->user_id != 0) {
                $user = $event->subscribe->user;
            }
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_UNSUBSCRIBE, $event->emailList, $user);
        });
    }
}
