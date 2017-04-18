<?php
/**
 * @todo  remove deprecated & commented code
 */
namespace wajox\yii2base\modules\payment\handlers;

use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\models\Log;
use wajox\yii2base\modules\payment\events\BillEvent;
use wajox\yii2base\handlers\BaseHandler;

class BillEventHandler extends BaseHandler
{
    public static function created(BillEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_NEW_BILL,
            $event->bill,
            $event->bill->user
        );
    }

    public static function returned(BillEvent $event)
    {
        /*
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->money_returned($order);
        }
        */
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_RETURN_BILL,
            $event->bill,
            $event->bill->user
        );
    }

    public static function paid(BillEvent $event)
    {
        /*
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->paid($order);
        }
        */
      
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_PAY_BILL,
            $event->bill,
            $event->bill->user
        );
    }
  
    public static function cancelled(BillEvent $event)
    {
        /*
        if ($event->bill->isWithOrder) {
            $order = $event->bill->order;
            \Yii::$app->ordersManager->cancelled($order);
        }
        */

        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_CANCEL_BILL,
            $event->bill,
            $event->bill->user
        );
    }
}
