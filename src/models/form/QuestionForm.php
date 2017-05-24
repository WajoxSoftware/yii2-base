<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;

class QuestionForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $verifyCode;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'message'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'email', 'subject', 'message'], 'filter', 'filter' => 'trim'],
            [['name', 'email', 'subject', 'message'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    public function send($request)
    {
        $to = $this->getApp()->params['adminEmail'];

        return ($request->isPost
            && $this->load($request->post())
            && $this->validate()
            && $this->sendTo($to)
        );
    }

    protected function sendTo($to)
    {
        $content = $this->message
            . PHP_EOL . $this->email
            . PHP_EOL . $this->name;

        $this
            ->getApp()
            ->mailer
            ->sendTransactional($to, $this->subject, $content, $content);

        return true;
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app/attributes', 'Email'),
            'name' => \Yii::t('app/attributes', 'Name'),
            'subject' => \Yii::t('app/attributes', 'Subject'),
            'message' => \Yii::t('app/attributes', 'Body'),
        ];
    }
}
