<?php
namespace wajox\yii2base\services\users;

use wajox\yii2base\models\User;
use wajox\yii2base\components\base\Object;

class UserMailer extends Object
{
    public $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function registration($password)
    {
        $email = $this->user->email;
        $subject = \Yii::t('app/mailer', 'User Mailer Registration Email Subject');
        $template = 'user_mailer/registration';
        $data = ['user' => $this->user, 'password' => $password];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    public function confirmation()
    {
        $email = $this->user->email;
        $subject = \Yii::t('app/mailer', 'User Mailer Confirmation Email Subject');
        $template = 'user_mailer/confirmation';
        $data = ['user' => $this->user];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    public function reset_password($password)
    {
        $email = $this->user->email;
        $subject = \Yii::t('app/mailer', 'User Mailer Reset Password Email Subject');
        $template = 'user_mailer/reset_password';
        $data = ['user' => $this->user, 'password' => $password];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }
}
