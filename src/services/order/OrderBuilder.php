<?php
namespace wajox\yii2base\services\order;

use wajox\yii2base\models\Bill;
use wajox\yii2base\models\Order;
use wajox\yii2base\models\OrderGood;
use wajox\yii2base\services\bill\BillsManager;
use wajox\yii2base\components\base\Object;

class OrderBuilder extends Object
{
    protected $bill;
    protected $order;
    protected $cartManager;
    protected $customer;
    protected $deliveryMethod;

    protected $goodsSum = 0;
    protected $goodsDeliverySum = 0;

    public function __construct($cartManager, $customer, $deliveryMethod)
    {
        $this->setCartManager($cartManager)
             ->setCustomer($customer)
             ->setDeliveryMethod($deliveryMethod);
    }

    public function save()
    {
        try {
            $this->createBill()
                 ->buildOrder()
                 ->saveOrder()
                 ->saveOrderGoods();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function getOrder()
    {
        return $this->order;
    }

    protected function setCartManager($cartManager)
    {
        $this->cartManager = $cartManager;

        $this->computeSum();

        return $this;
    }

    protected function getCartManager()
    {
        return $this->cartManager;
    }

    protected function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    protected function getCustomer()
    {
        return $this->customer;
    }

    protected function setDeliveryMethod($deliveryMethod)
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    protected function getDeliveryMethod()
    {
        return $this->deliveryMethod;
    }

    protected function computeSum()
    {
        $this->goodsSum = $this->getCartManager()->getSum();
        $this->goodsDeliverySum = $this->getCartManager()->getDeliverySum();

        return $this;
    }

    protected function getTotalSum()
    {
        return $this->getGoodsSum() + $this->getGoodsDeliverySum();
    }

    protected function getGoodsSum()
    {
        return $this->goodsSum;
    }

    protected function getGoodsDeliverySum()
    {
        return $this->goodsDeliverySum;
    }

    protected function getBill()
    {
        return $this->bill;
    }

    protected function createBill()
    {
        $bill = $this->getBillsManager()->create([
          'Bill' => [
            'sum' => $this->getTotalSum(),
            'payment_destination_id' => Bill::DESTINATION_ID_ORDER,
          ],
        ], $this->getCustomer());

        if ($bill->isNewRecord) {
            throw new \Exception('Can not create bill');
        }

        $this->bill = $bill;

        return $this;
    }

    protected function buildOrder()
    {
        $model = $this->createObject(Order::className());
        $model->created_at = time();
        $model->customer_id = $this->getCustomer()->id;
        $model->user_id = $this->getCustomer()->user_id;
        $model->bill_id = $this->getBill()->id;
        $model->sum = $this->getGoodsSum();
        $model->delivery_sum = $this->getGoodsDeliverySum();
        $model->delivery_method = $this->getDeliveryMethod();
        $model->status_id = Order::STATUS_ID_NEW;
        $model->status_at = time();
        $model->delivery_status_at = time();
        $model->delivery_status_id = Order::DELIVERY_STATUS_ID_WAITING;

        $this->order = $model;

        return $this;
    }

    protected function saveOrder()
    {
        if ($this->order->save()
            && $this->order->updateStatus(Order::STATUS_ID_NEW, Order::DELIVERY_STATUS_ID_WAITING)
        ) {
            return $this;
        }

        throw new \Exception('Can not save order');
    }

    protected function saveOrderGoods()
    {
        $orderGoods = [];

        foreach ($this->getCartmanager()->getCartItems() as $id => $cartItem) {
            $orderGood = $this->createObject(OrderGood::className());
            $orderGood->items_count = $cartItem['count'];
            $orderGood->good_id = $id;
            $orderGood->order_id = $this->getOrder()->id;

            if (!$orderGood->save()) {
                throw new \Exception('Can not attach good to this order');
            }

            $orderGoods[] = $orderGood;
        }

        $this->orderGoods = $orderGoods;

        return $this;
    }

    protected function getBillsManager()
    {
        return $this->getDependency(BillsManager::className());
    }
}
