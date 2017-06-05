<?php
namespace wajox\yii2base\modules\shop\handlers;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\events\GoodEvent;
use wajox\yii2base\modules\shop\services\GoodLettersBuilder;
use wajox\yii2base\modules\shop\services\PurchasesManager;
use wajox\yii2base\models\Log;
use wajox\yii2base\handlers\BaseHandler;

class GoodEventHandler extends BaseHandler
{
    public static function orderStatusChanged($event)
    {
        $lettersBuilder = new GoodLettersBuilder($event->order);
        $lettersBuilder->processDeliveryStatus();
    }

    public static function orderCreated($event)
    {
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

    public static function orderPaid($event)
    {
        (new PurchasesManager($event->order->user))->addOrder($event->order);

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

    public static function orderReturned($event)
    {
        (new PurchasesManager())->dropOrder($event->order);
    }

    public static function ordered($event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_GOOD_ORDER,
            $event->good->id
        );
    }
    
    public static function paid($event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_GOOD_PAY,
            $event->good->id
        );
    }
}
