<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'email', 'subject', 'body'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    public function contact($email)
    {
        if ($this->validate()) {
            $this->getApp()->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app/attributes', 'Email'),
            'verifyCode' => \Yii::t('app/attributes', 'Verify Code'),
            'name' => \Yii::t('app/attributes', 'Name'),
            'subject' => \Yii::t('app/attributes', 'Subject'),
            'body' => \Yii::t('app/attributes', 'Body'),
        ];
    }
}
