<?php

namespace wajox\yii2base\services\order;

use wajox\yii2base\models\Order;
use wajox\yii2base\models\GoodDeliveryMethod;
use wajox\yii2base\services\events\types\OrderEvent;
use wajox\yii2base\services\shop\ShopCartManager;
use wajox\yii2base\components\base\Object;

class OrdersManager extends Object
{
    /**
     * if goods in order incompatibile by delivery method
     * then split the order into few new orders
     *
     * @param $cartManager
     * @param $customer
     */
    public function createOrders($cartManager, $customer)
    {
        $cartItems = $cartManager->getCartItems();
        $goodsIds = array_keys($cartItems);

        $methods = $this
            ->getRepository()
            ->find(GoodDeliveryMethod::className())
            ->where([
                'good_id' => $goodsIds,
            ])
            ->indexBy('good_id')
            ->all();

        $groups = [];
        foreach ($methods as $goodId => $method) {
            if (!isset($groups[$method->delivery_method])) {
                $groups[$method->delivery_method] = $this
                    ->createObject(
                        ShopCartManager::className(),
                        [
                            $customer->user,
                            false,
                        ]
                    );
            }

            $count = $cartItems[$goodId];
            $groups[$method->delivery_method]->addItem($goodId, $count);
        }

        $orders = [];
        foreach ($groups as $methodName => $groupCartManager) {
            $order = $this->create(
                $methodName,
                $groupCartManager,
                $customer
            );

            if ($order && !$order->isNewRecord) {
                $orders[]  = $order;
            }
        }

        return $orders;
    }

    /**
     * Create order with given shopping cart and delivery method
     *
     * @param $deliveryMethod
     * @param $cartManager
     * @param $customer
     */
    public function create($deliveryMethod, $cartManager, $customer)
    {
        $builder = $this->createObject(
            OrderBuilder::className(),
            [
                $cartManager,
                $customer,
                $deliveryMethod,
            ]
        );

        if ($builder->save()) {
            $this->triggerEvent(
                $builder->getOrder(),
                OrderEvent::EVENT_CREATED
            );
        }

        return $builder->getOrder();
    }

    public function paid($model)
    {
        if ($model->isPaid) {
            return $model;
        }

        $model->updateStatus(Order::STATUS_ID_PAID);

        $this->triggerEvent($model, OrderEvent::EVENT_PAID);

        return $model;
    }

    public function cancelled($model)
    {
        if (!$model->isNew) {
            return $model;
        }

        $model->updateStatus(Order::STATUS_ID_CANCELLED);

        $this->triggerEvent($model, OrderEvent::EVENT_CANCELLED);

        return $model;
    }

    public function money_returned($model)
    {
        if (!$model->isPaid) {
            return $model;
        }

        $model->updateStatus(Order::STATUS_ID_RETURNED);

        $this->triggerEvent($model, OrderEvent::EVENT_MONEY_RETURNED);

        return $model;
    }

    public function prepared($model)
    {
        if (!$model->isDeliveryWaiting) {
            return $model;
        }

        $model->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_PREPARED);

        $this->triggerEvent($model, OrderEvent::EVENT_PREPARED);

        return $model;
    }

    public function send($model)
    {
        if (!$model->isPrepared) {
            return $model;
        }

        $model->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_SEND);

        $this->triggerEvent($model, OrderEvent::EVENT_SEND);

        return $model;
    }

    public function delivered($model)
    {
        if (!$model->isSend) {
            return $model;
        }

        $model->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_DELIVERED);

        $this->triggerEvent($model, OrderEvent::EVENT_DELIVERED);

        return $model;
    }

    public function undelivered($model)
    {
        if (!$model->isSend) {
            return $model;
        }

        $model->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_UNDELIVERED);

        $this->triggerEvent($model, OrderEvent::EVENT_UNDELIVERED);

        return $model;
    }

    public function returned($model)
    {
        if (!$model->isDelivered &&
       !$model->isUndelivered &&
       !$model->isSend
    ) {
            return $model;
        }

        $model->updateDeliveryStatus(Order::DELIVERY_STATUS_ID_RETURNED);

        $this->triggerEvent($model, OrderEvent::EVENT_RETURNED);

        return $model;
    }

    public function triggerEvent($model, $type)
    {
        $event = $this->createObject(OrderEvent::className());
        $event->order = $model;
        
        $this
            ->getApp()
            ->eventsManager
            ->trigger(
                Order::className(),
                $type,
                $event
            );
    }
}
