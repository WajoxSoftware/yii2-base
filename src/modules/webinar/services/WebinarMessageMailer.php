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
        $body = '<p>Имя: ' . $this->message->name . '</p>'
            . '<p>Эл. почта: ' . $this->message->email . '</p>'
            . '<p>Сообщение: ' . $this->message->message . '</p>';

        $email = $this->getApp()->params['webinarAdminEmail'];
        $headers = 'From: ' . $this->message->email . "\r\n"
            . 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($email, $subject, $body, $headers);

        return true;
    }
}
