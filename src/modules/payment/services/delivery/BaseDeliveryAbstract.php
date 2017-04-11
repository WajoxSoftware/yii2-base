<?php
namespace wajox\yii2base\modules\payment\services\delivery;

use wajox\yii2base\modules\payment\models\GoodDeliveryMethod;
use wajox\yii2base\components\base\Object;

abstract class BaseDeliveryAbstract extends Object
{
    public function getClassShort(): string
    {
        return str_replace(__NAMESPACE__ . '\\', '', get_called_class());
    }

    public function getClass(): string
    {
        return get_called_class();
    }

    public function getId(): string
    {
        return $this->getClassShort();
    }

    public function getTitle(): string
    {
        return \Yii::t('app/general', 'Delivery Method '.$this->getClassShort());
    }

    public function getSettings(): array
    {
        return $this->getApp()->systemPaymentSettings->get($this->getClass());
    }

    public function is($id): bool
    {
        return $id == $this->getId();
    }

    public function processNewOrder($order): bool
    {
        return true;
    }

    public function processPaidOrder($order): bool
    {
        return true;
    }

    public function processSendOrder($order): bool
    {
        return true;
    }

    public function processCancelledOrder($order): bool
    {
        return true;
    }

    public function processPreparedOrder($order): bool
    {
        return true;
    }

    public function processDeliveredOrder($order): bool
    {
        return true;
    }

    public function processUndeliveredOrder($order): bool
    {
        return true;
    }

    public function processReturnedOrder($order): bool
    {
        return true;
    }

    public function processMoneyReturnedOrder($order): bool
    {
        return true;
    }

    public function attachGood($good, $params = [])
    {
        $this->buildGoodMethod($good, $params)->save();

        $this->afterAttach($good, $params);
    }

    protected function buildGoodMethod($good, $params)
    {
        $price = 0;
        $extra = [];

        if (isset($params['price']) && is_numeric($params['price'])) {
            $price = $params['price'];
        }

        if (isset($params['extra']) && is_array($params['extra'])) {
            $extra = $params['extra'];
        }

        $method = $this->createObject(GoodDeliveryMethod::className());
        $method->good_id = $good->id;
        $method->delivery_method  = $this->getId();
        $method->delivery_price = $price;
        $method->extra = $extra;

        return $method;
    }

    public function detachGood($good)
    {
        $this->getRepository()->deleteAll(
            GoodDeliveryMethod::className(),
            [
                'good_id' => $good->id,
                'delivery_method' => $this->getId(),
            ]
        );

        $this->afterDetach($good);
    }

    protected function afterAttach($good, $params)
    {
        ;
    }

    protected function afterDetach($good)
    {
        ;
    }
}
