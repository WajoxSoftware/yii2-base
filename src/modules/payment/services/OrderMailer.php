<?php
namespace wajox\yii2base\modules\payment\services;

use wajox\yii2base\components\base\Object;

class OrderMailer extends Object
{
    const NOTIFICATIONS_ENABLED_PARAM = 'orderEmailNotifications';

    public $order = null;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function send_order($goods)
    {
        if ($this->isDisabled()) {
            return false;
        }

        $subject = \Yii::t('app/mailer', 'Order Mailer Send Order');
        $template = 'order_mailer/send_order';
        $email = $this->order->customer->email;
        $data = ['order' => $this->order, 'goods' => $goods];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    public function new_status()
    {
        if ($this->isDisabled()) {
            return false;
        }

        $subject = \Yii::t('app/mailer', 'Order Mailer New Order Status');
        $template = 'order_mailer/order_status';
        $email = $this->order->customer->email;
        $data = ['order' => $this->order];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);
    }

    protected function isDisabled()
    {
        if (!$this->order->customer) {
            return true;
        }

        return \Yii::$app->params[self::NOTIFICATIONS_ENABLED_PARAM] !== true;
    }
}
