<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\services\notifications\UserNotificationMailer;

class UserNotificationsController extends Controller
{
    public function actionSend()
    {
        foreach ($this->getUsers()->each() as $user) {
            (new  UserNotificationMailer($user))->newNotifications();
        }
    }

    protected function getUsers()
    {
        return \wajox\yii2base\models\User::find();
    }
}
