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
        $subject = \Yii::t('app/mailer', 'Webinar Mailer Send Question');
        $template = 'webinar_mailer/send_question';
        $email = $this->getApp()->params['webinarAdminEmail'];

        $data = ['message' => $this->message];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }
}
