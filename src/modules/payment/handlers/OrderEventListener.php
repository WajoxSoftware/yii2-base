<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\payment\models\Order;
use wajox\yii2base\models\Log;
use wajox\yii2base\services\order\OrderMailer;
use wajox\yii2base\services\events\OrderEvent;
use wajox\yii2base\services\events\GoodEvent;
use wajox\yii2base\modules\payment\servicesOrderDeliveryManager;
use wajox\yii2base\services\partner\PartnerFeeManager;
use wajox\yii2base\services\subscribes\SubscribesManager;
use wajox\yii2base\modules\shop\services\GoodLettersBuilder;
use wajox\yii2base\modules\shop\services\PurchasesManager;
use wajox\yii2base\services\notifications\UserNotificationsManager;
use wajox\yii2base\handlers\BaseHandler;

class OrderEventHandler extends BaseHandler
{
    public static function created(OrderEvent $event)
    {
        //after create callbacks
        OrderDeliveryManager::processNewOrder($event->order);
        SubscribesManager::subscribeOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_NEW_ORDER,
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
    }

    public static function paid(OrderEvent $event)
    {
        OrderDeliveryManager::processPaidOrder($event->order);
        PartnerFeeManager::processOrder($event->order);
        OrderEventHandler::onEvent($event);

        (new PurchasesManager($event->order->user))->addOrder($event->order);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_PAY_ORDER,
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
    }


    public static function cancelled(OrderEvent $event)
    {
        OrderDeliveryManager::processCancelledOrder($event->order);
        OrderEventHandler::onEvent($event);
        OrderEventHandler::logEvent(Log::TYPE_ID_CANCEL_ORDER, $event);
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_RETURN_ORDER,
            $event->order,
            $event->order->user
        );
    }

    
    public static function moneyback(OrderEvent $event)
    {
        OrderDeliveryManager::processMoneyReturnedOrder($event->order);
        PartnerFeeManager::dropOrder($event->order);
        PurchasesManager::dropOrder($event->order);

        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_MONEYBACK_ORDER,
            $event->order,
            $event->order->user
        );
    }

    public static function prepared(OrderEvent $event)
    {
        OrderDeliveryManager::processPreparedOrder($event->order);
        OrderEventHandler::onEvent($event);
    }

    public static function send(OrderEvent $event)
    {
        OrderDeliveryManager::processSendOrder($event->order);
        OrderEventHandler::onEvent($event);
    }

    public static function delivered(OrderEvent $event)
    {
        OrderDeliveryManager::processDeliveredOrder($event->order);
        OrderEventHandler::onEvent($event);
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_DELIVER_ORDER,
            $event->order,
            $event->order->user
        );
    }

    public static function undelivered(OrderEvent $event)
    {
        OrderDeliveryManager::processUndeliveredOrder($event->order);
        OrderEventHandler::onEvent($event);
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_UNDELIVER_ORDER,
            $event->order,
            $event->order->user
        );
    }

    public static function returned(OrderEvent $event)
    {
        OrderDeliveryManager::processReturnedOrder($event->order);
        OrderEventHandler::onEvent($event);
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_RETURN_ORDER,
            $event->order,
            $event->order->user
        );
    }

    public static function onEvent(OrderEvent $event)
    {
        $lettersBuilder = new GoodLettersBuilder($event->order);
        $lettersBuilder->processDeliveryStatus();

        (new UserNotificationsManager($event->order->user))->orderStatusNotification($event->order);

        $om = new OrderMailer($event->order);
        $om->new_status();
    }
}
