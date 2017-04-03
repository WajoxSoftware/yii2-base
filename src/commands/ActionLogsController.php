<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;

class ActionLogsController extends Controller
{
    public function actionCreate($typeId, $itemId, $userId, $jsonParams)
    {
        \Yii::$app
            ->actionLogs
            ->saveLog(
                $typeId,
                $itemId,
                $userId,
                json_decode($jsonParams, true)
            );
    }
}