<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;

class ActionLogsController extends Controller
{
    public function actionCreate($typeId, $itemId, $userId, $jsonParams)
    {
        $user = \Yii::$app
            ->usersManager
            ->findById($userId);

        \Yii::$app
            ->actionLogs
            ->log(
                $typeId,
                $itemId,
                $userId,
                json_decode($jsonParams, true)
            );
    }
}
