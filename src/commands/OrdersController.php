<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;

class OrdersController extends Controller
{
    public function actionSynch()
    {
        \Yii::$app->orderCodManager->synchronize();
    }
}
