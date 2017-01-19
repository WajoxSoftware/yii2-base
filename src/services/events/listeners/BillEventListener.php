<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\models\Bill;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\services\events\types\BillEvent;
use wajox\yii2base\services\order\OrdersManager;
use wajox\yii2base\services\system\EventsManager;

class BillEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager $eventsManager)
    {
        $eventsManager->on(Bill::className(), BillEvent::EVENT_CREATED, function ($event) {
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_NEW_BILL, $event->bill, $event->bill->user);
        });

        $eventsManager->on(Bill::className(), BillEvent::EVENT_RETURNED, function ($event) {
            if ($event->bill->isWithOrder) {
                $order = $event->bill->order;
                OrdersManager::money_returned($order);
            }
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_RETURN_BILL, $event->bill, $event->bill->user);
        });

        $eventsManager->on(Bill::className(), BillEvent::EVENT_PAID, function ($event) {
            if ($event->bill->isWithOrder) {
                $order = $event->bill->order;
                OrdersManager::paid($order);
            }
          
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_PAY_BILL, $event->bill, $event->bill->user);
        });

        $eventsManager->on(Bill::className(), BillEvent::EVENT_CANCELLED, function ($event) {
            if ($event->bill->isWithOrder) {
                $order = $event->bill->order;
                OrdersManager::cancelled($order);
            }
            \Yii::$app->userActionLogs->log(UserActionLog::TYPE_ID_CANCEL_BILL, $event->bill, $event->bill->user);
        });
    }
}
