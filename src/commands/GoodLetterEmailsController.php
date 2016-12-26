<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\services\shop\GoodLetterEmailsSender;

class GoodLetterEmailsController extends Controller
{
    public function actionSend()
    {
        (new GoodLetterEmailsSender())->run();
    }
}
