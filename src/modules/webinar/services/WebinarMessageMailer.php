<?php
namespace wajox\yii2base\modules\webinar\services;

use wajox\yii2base\components\base\Object;

class WebinarMessageMailer extends Object
{
    public $message = null;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function sendQuestion()
    {
        $subject = 'Сообщение участника вебинара';
        $message = '<p>Имя: ' . $message->name . '</p>'
            . '<p>Эл. почта: ' . $message->email . '</p>'
            . '<p>Сообщение: ' . $message->message . '</p>';

        $email = $this->getApp()->params['webinarAdminEmail'];
        $headers = 'From: ' . $message->email . "\r\n";

        mail($email, $subject, $message, $headers);

        return true;
    }
}
