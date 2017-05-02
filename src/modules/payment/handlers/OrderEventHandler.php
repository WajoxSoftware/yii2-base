<?php
namespace wajox\yii2base\modules\payment\handlers;

use wajox\yii2base\modules\payment\models\Order;
use wajox\yii2base\models\Log;
use wajox\yii2base\modules\payment\services\OrderMailer;
use wajox\yii2base\modules\payment\events\events\OrderEvent;
use wajox\yii2base\modules\payment\events\BillEvent;
use wajox\yii2base\modules\payment\events\OrderEvent;
use wajox\yii2base\modules\payment\services\OrderDeliveryManager;
use wajox\yii2base\modules\partner\services\PartnerFeeManager;
use wajox\yii2base\services\notifications\UserNotificationsManager;
use wajox\yii2base\handlers\BaseHandler;

class OrderEventHandler extends BaseHandler
{
    public static function billPaid(BillEvent $event)
    {
        if (!$event->bill->isWithOrder) {
            return;
        }

        \Yii::$app->ordersManager->paid($event->bill->order);
    }

    public static function billCancelled(BillEvent $event)
    {
        if (!$event->bill->isWithOrder) {
            return;
        }
        
        \Yii::$app->ordersManager->cancelled($event->bill->order);
    }

    public static function billReturned(BillEvent $event)
    {
        if (!$event->bill->isWithOrder) {
            return;
        }

        \Yii::$app->ordersManager->money_returned($event->bill->order);
    }

    public static function created(OrderEvent $event)
    {
        //after create callbacks
        OrderDeliveryManager::processNewOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_NEW_ORDER,
            $event->order->id,
            $event->order->user
        );
    }

    public static function paid(OrderEvent $event)
    {
        OrderDeliveryManager::processPaidOrder($event->order);
        PartnerFeeManager::processOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_PAY_ORDER,
            $event->order->id,
            $event->order->user
        );
    }


    public static function cancelled(OrderEvent $event)
    {
        OrderDeliveryManager::processCancelledOrder($event->order);
        OrderEventHandler::onEvent($event);
        OrderEventHandler::logEvent(Log::TYPE_ID_CANCEL_ORDER, $event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_RETURN_ORDER,
            $event->order->id,
            $event->order->user
        );
    }

    
    public static function moneyback(OrderEvent $event)
    {
        OrderDeliveryManager::processMoneyReturnedOrder($event->order);
        PartnerFeeManager::dropOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_MONEYBACK_ORDER,
            $event->order->id,
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
            $event->order->id,
            $event->order->user
        );
    }

    public static function undelivered(OrderEvent $event)
    {
        OrderDeliveryManager::processUndeliveredOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_UNDELIVER_ORDER,
            $event->order->id,
            $event->order->user
        );
    }

    public static function returned(OrderEvent $event)
    {
        OrderDeliveryManager::processReturnedOrder($event->order);
        OrderEventHandler::onEvent($event);

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_RETURN_ORDER,
            $event->order->id,
            $event->order->user
        );
    }

    public static function onEvent(OrderEvent $event)
    {
        (new UserNotificationsManager($event->order->user))->orderStatusNotification($event->order);

        $om = new OrderMailer($event->order);
        $om->new_status();
    }
}
