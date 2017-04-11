<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\models\Order;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\services\order\OrderMailer;
use wajox\yii2base\modules\payment\events\types\OrderEvent;
use wajox\yii2base\services\events\types\GoodEvent;
use wajox\yii2base\services\order\OrderDeliveryManager;
use wajox\yii2base\services\partner\PartnerFeeManager;
use wajox\yii2base\services\subscribes\SubscribesManager;
use wajox\yii2base\services\shop\GoodLettersBuilder;
use wajox\yii2base\services\shop\PurchasesManager;
use wajox\yii2base\services\notifications\UserNotificationsManager;
use wajox\yii2base\services\system\EventsManager;

class OrderEventListener extends BaseListenerAbstract
{
    public function bindEvents(EventsManager $eventsManager)
    {
        $eventsManager->on(Order::className(), OrderEvent::EVENT_CREATED, function ($event) {
            //after create callbacks
            OrderDeliveryManager::processNewOrder($event->order);
            SubscribesManager::subscribeOrder($event->order);
            OrderEventHandler::onEvent($event);

            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_NEW_ORDER,
                $event->order,
                $event->order->user
            );

            foreach ($event->order->goods as $good) {
                $event = new GoodEvent();
                $event->good = $good;

                \Yii::$app->eventsManager->trigger(
                    Good::className(),
                    GoodEvent::EVENT_ORDERED,
                    $event
                );
            }
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_PAID, function ($event) {
            OrderDeliveryManager::processPaidOrder($event->order);
            PartnerFeeManager::processOrder($event->order);
            OrderEventHandler::onEvent($event);

            (new PurchasesManager($event->order->user))->addOrder($event->order);

            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_PAY_ORDER,
                $event->order,
                $event->order->user
            );

            foreach ($event->order->goods as $good) {
                $event = new GoodEvent();
                $event->good = $good;
                \Yii::$app->eventsManager->trigger(
                    Good::className(),
                    GoodEvent::EVENT_PAID,
                    $event
                );
            }
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_CANCELLED, function ($event) {
            OrderDeliveryManager::processCancelledOrder($event->order);
            OrderEventHandler::onEvent($event);
            OrderEventHandler::logEvent(UserActionLog::TYPE_ID_CANCEL_ORDER, $event);
            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_RETURN_ORDER,
                $event->order,
                $event->order->user
            );
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_MONEY_RETURNED, function ($event) {
            OrderDeliveryManager::processMoneyReturnedOrder($event->order);
            PartnerFeeManager::dropOrder($event->order);
            PurchasesManager::dropOrder($event->order);

            OrderEventHandler::onEvent($event);

            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_MONEYBACK_ORDER,
                $event->order,
                $event->order->user
            );
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_PREPARED, function ($event) {
            OrderDeliveryManager::processPreparedOrder($event->order);
            OrderEventHandler::onEvent($event);
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_SEND, function ($event) {
            OrderDeliveryManager::processSendOrder($event->order);
            OrderEventHandler::onEvent($event);
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_DELIVERED, function ($event) {
            OrderDeliveryManager::processDeliveredOrder($event->order);
            OrderEventHandler::onEvent($event);
            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_DELIVER_ORDER,
                $event->order,
                $event->order->user
            );
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_UNDELIVERED, function ($event) {
            OrderDeliveryManager::processUndeliveredOrder($event->order);
            OrderEventHandler::onEvent($event);
            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_UNDELIVER_ORDER,
                $event->order,
                $event->order->user
            );
        });

        $eventsManager->on(Order::className(), OrderEvent::EVENT_RETURNED, function ($event) {
            OrderDeliveryManager::processReturnedOrder($event->order);
            OrderEventHandler::onEvent($event);
            \Yii::$app->userActionLogs->log(
                UserActionLog::TYPE_ID_RETURN_ORDER,
                $event->order,
                $event->order->user
            );
        });
    }

    public static function onEvent($event)
    {
        $lettersBuilder = new GoodLettersBuilder($event->order);
        $lettersBuilder->processDeliveryStatus();

        (new UserNotificationsManager($event->order->user))->orderStatusNotification($event->order);

        $om = new OrderMailer($event->order);
        $om->new_status();
    }
}
