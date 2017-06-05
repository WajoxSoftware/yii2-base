<?php
namespace wajox\yii2base\modules\payment\services;

use wajox\yii2base\components\base\Object;

class OrderMailSender extends Object
{
    public $order = null;
    public $status = 'unstarted';
    public $unsend_goods = [];
    public $goods = [];

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function send()
    {
        foreach ($this->order->goods as $good) {
            $this->addGood($good);
        }

        return $this->sendMail();
    }

    public function haveUnsendGoods()
    {
        return count($this->unsend_goods) > 0;
    }

    private function addGood($good)
    {
        $this->goods[$good->id] = $good;
    }

    private function sendMail()
    {
        $mailer = $this->createObject(OrderMailer::className(), [$this->order]);

        return $mailer->send_order($this->goods);
    }
}
