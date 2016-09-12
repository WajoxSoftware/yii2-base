<?php
namespace wajox\yii2base\services\mail;

class SwiftSenderAdapter extends SenderAdapterAbstract
{
    public $user = null;

    public $from = null;

    public function __construct($params = [])
    {
        $this->from = $params['from'];
    }

    public function send($to, $subject, $template, $data = [], $options = [])
    {
        $from = isset($optinos['from']) ? $options['from'] : $this->from;

        $message = \Yii::$app->swiftMailer->compose([
                'html' => $template.'_html',
                'text' => $template.'_text',
              ], $data)
            ->setFrom($from)
            ->setSubject('registration email');

        $to = !is_array($to) ? [$to] : $to;

        $success = true;
        foreach ($to as $email) {
            $m = clone $message;
            if (!$m->setTo($email)->send()) {
                $success = false;
            }
        }

        return $success;
    }

    public function addSubscriber($email, $name)
    {
        return true;
    }

    public function deleteUserFromList($email, $listId)
    {
        return true;
    }

    public function addUserToList($data)
    {
        return true;
    }
}
