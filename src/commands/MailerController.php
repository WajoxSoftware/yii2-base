<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;

class MailerController extends Controller
{
    public function actionLists()
    {
        print_r(\Yii::$app->mailer->getLists());
    }

    public function actionSend()
    {
        print_r(\Yii::$app->mailer->sendTransactional(
            'wajox@mail.ru',
            'Test',
            'Text',
            '<b>Html</b>'
        ));
    }
}
