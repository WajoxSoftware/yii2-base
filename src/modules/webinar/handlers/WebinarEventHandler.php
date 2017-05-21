<?php
namespace wajox\yii2base\modules\webinar\handlers;

use wajox\yii2base\modules\webinar\events\WebinarEvent;
use wajox\yii2base\models\Log;
use wajox\yii2base\handlers\BaseHandler;

class WebinarEventHandler extends BaseHandler
{
    public static function start(WebinarEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_WEBINAR_START,
            $event->webinar->id
        );
    }

    public static function finish(WebinarEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_WEBINAR_FINISH,
            $event->webinar->id
        );
    }

    public static function advert(WebinarEvent $event)
    {
        \Yii::$app->actionLogs->log(
            Log::TYPE_ID_WEBINAR_ADVERT,
            $event->webinar->id
        );
    }
}
