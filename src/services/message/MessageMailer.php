<?php
namespace wajox\yii2base\services\message;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Message;
use wajox\yii2base\components\base\Object;

class MessageMailer extends Object
{
    public $message = null;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function new_message()
    {
        if (!$this->message->receiverUser) {
            return false;
        }

        $subject = \Yii::t('app/mailer', 'Message Mailer New Message Subject');
        $template = 'message_mailer/new_message';
        $email = $this->message->receiverUser->email;
        $data = ['user' => $this->message->receiverUser, 'message' => $this->message];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }
}
