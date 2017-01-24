<?php
namespace wajox\yii2base\services\shop;

use wajox\yii2base\models\GoodLetter;
use wajox\yii2base\models\GoodLetterEmail;
use wajox\yii2base\models\Order;
use wajox\yii2base\components\base\Object;

class GoodLettersBuilder extends Object
{
    protected $order;

    public function __construct($order)
    {
        $this->setOrder($order);
    }

    protected function setOrder($order)
    {
        $this->order = $order;

        return $order;
    }

    public function processDeliveryStatus()
    {
        $letterTypeId = $this->getLetterTypeId();
        $goodIds = array_map(
            function ($item) {
                return $item->id;
            },
            $this->order->goods
        );

        $goodLettersQuery = $this
            ->getRepository()
            ->find(GoodLetter::className())
            ->where([
                'good_id' => $goodIds,
                'type_id' => $letterTypeId,
            ]);

        foreach ($goodLettersQuery->each() as $goodLetter) {
            $this->createEmail($goodLetter);
        }
    }

    protected function createEmail($goodLetter)
    {
        $model = $this->createObject(GoodLetterEmail::className());
        $model->order_id = $this->order->id;
        $model->good_email_id = $goodLetter->id;
        $model->scheduled_at = intval(time() + $goodLetter->delay * 3600);
        $model->status_id = GoodLetterEmail::STATUS_ID_NEW;
        $model->save();
    }

    protected function getLetterTypeId()
    {
        $table = $this->getTypesMatchTable();

        if (!isset($table[$this->order->delivery_method])) {
            return;
        }

        $types = $table[$this->order->delivery_method];

        if (!isset($types[$this->order->delivery_status_id])) {
            return;
        }

        return $types[$this->order->delivery_status_id];
    }

    protected function getTypesMatchTable()
    {
        return [
            'CodDelivery' => [
                 Order::DELIVERY_STATUS_ID_WAITING => GoodLetter::TYPE_ID_COD_ORDER_NEW,
                 Order::DELIVERY_STATUS_ID_PREPARED => GoodLetter::TYPE_ID_COD_ORDER_PAID,
                 Order::DELIVERY_STATUS_ID_SEND => GoodLetter::TYPE_ID_COD_ORDER_SEND,
                 Order::DELIVERY_STATUS_ID_DELIVERED => GoodLetter::TYPE_ID_COD_ORDER_DELIVERED,
                 Order::DELIVERY_STATUS_ID_RETURNED => GoodLetter::TYPE_ID_COD_ORDER_RETURNED,
            ],

            'EmailDelivery' => [
                Order::DELIVERY_STATUS_ID_WAITING => GoodLetter::TYPE_ID_E_ORDER_NEW,
                Order::DELIVERY_STATUS_ID_DELIVERED => GoodLetter::TYPE_ID_E_ORDER_PAID,
            ],

            'SystemDelivery' => [
                 Order::DELIVERY_STATUS_ID_WAITING => GoodLetter::TYPE_ID_ORDER_NEW,
                 Order::DELIVERY_STATUS_ID_PREPARED => GoodLetter::TYPE_ID_ORDER_PAID,
                 Order::DELIVERY_STATUS_ID_SEND => GoodLetter::TYPE_ID_COD_ORDER_SEND,
                 Order::DELIVERY_STATUS_ID_DELIVERED => GoodLetter::TYPE_ID_ORDER_DELIVERED,
                 Order::DELIVERY_STATUS_ID_RETURNED => GoodLetter::TYPE_ID_ORDER_RETURNED,
            ],

        ];
    }
}
