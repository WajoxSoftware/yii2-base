<?php
namespace wajox\yii2base\services\order;

use wajox\yii2base\models\UserNotification;
use wajox\yii2base\components\base\Object;

class UserNotificationMailer extends Object
{
    const NOTIFICATION_INTERVAL = 60; // interval in minutes

    protected $user = null;
    protected $notifications = [];

    public function __construct($user)
    {
        $this->setUser($user);
    }

    public function newNotifications()
    {
        if (!$this->getUser()
            || sizeof($this->notifications) == 0
            || !$this->getUser()->notificationsEnabled
        ) {
            return false;
        }

        $subject = \Yii::t(
            'app/mailer',
            'You have new unread notifications'
        );

        $template = 'notification_mailer/new_notifications';
        $email = $this->user->email;
        $data = ['notifications' => $this->notifications];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    protected function setUser($user)
    {
        $this->user = $user;
        $this->loadNotifications();

        return $this;
    }

    protected function getUser()
    {
        return $this->user;
    }

    protected function loadNotifications()
    {
        $lastTime = time() - self::NOTIFICATION_INTERVAL * 60;

        $this->notifications = $this
            ->getRepository()
            ->find(UserNotification::className())
            ->where([
                'user_id' => $this->getUser()->id,
                'status_id' => UserNotification::STATUS_ID_NEW,
            ])
            ->andWhere([
                '>=', 'created_at', $lastTime,
            ])
            ->all();

        return $this;
    }
}
