<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\models\Log;
use wajox\yii2base\components\base\Object;

class ClicksManager extends Object
{
    public function save()
    {
        $this
            ->getApp()
            ->actionLogs
            ->log(Log::TYPE_ID_CLICK_NEW);
    }
}
