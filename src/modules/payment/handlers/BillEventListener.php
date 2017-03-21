<?php
namespace wajox\yii2base\services\events\listeners;

use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\models\UserActionLog;
use wajox\yii2base\modules\payment\events\illEvent;
use wajox\yii2base\handlers\BaseHandler;

class BillEventHandler extends BaseHandler
{
    public static function created(BillEvent $event)
    {
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_NEW_BILL,
            $event->bill,
            $event->bill->user
        );
    }

    public static function returned(BillEvent $event)
    {
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->money_returned($order);
        }

        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_RETURN_BILL,
            $event->bill,
            $event->bill->user
        );
    }

    public static function paid(BillEvent $event)
    {
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->paid($order);
        }
      
        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_PAY_BILL,
            $event->bill,
            $event->bill->user
        );
    }

  
    public static function cancelled(BillEvent $event)
    {
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->cancelled($order);
        }

        \Yii::$app->userActionLogs->log(
            UserActionLog::TYPE_ID_CANCEL_BILL,
            $event->bill,
            $event->bill->user
        );
    }
}
