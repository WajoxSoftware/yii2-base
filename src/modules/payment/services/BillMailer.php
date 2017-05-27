<?php
namespace wajox\yii2base\modules\payment\services;

use wajox\yii2base\components\base\Object;

class BillMailer extends Object
{
    public $bill = null;

    public function __construct($bill)
    {
        $this->bill = $bill;
    }

    public function sendQuestion($question)
    {
        if ($this->isDisabled()) {
            return false;
        }

        $subject = \Yii::t('app/mailer', 'Bill Mailer Send Question');
        $template = 'bill_mailer/send_question';
        $email = $this->getApp()->params['adminEmail'];

        $data = ['bill' => $this->bill, 'question' => $question];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    protected function isDisabled()
    {
        return $this->bill->customer != null;
    }
}
