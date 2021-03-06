<?php
namespace wajox\yii2base\modules\shop\controllers;

use wajox\yii2base\modules\payment\models\form\OrderForm;
use wajox\yii2base\modules\shop\services\ShopCartManager;
use yii\web\ForbiddenHttpException;

class OrderController extends ApplicationController
{
    public function actionCreate()
    {
        $this
            ->getApp()
            ->shopCart
            ->loadGoods();

        $model = $this->createObject(OrderForm::className());
        $model->setGoods($this->getApp()->shopCart->getGoods());
        
        $request = $this->getApp()->request;

        if (!$this->getApp()->user->isGuest
            && !$request->isPost
        ) {
            $model = $this->buildDefaultOrderForm($model);
        }

        if ($request->isPost
            && $model->load($request->post())
            && $model->validate()
        ) {
            $orders = $this->createOrders(
                $model,
                $this->getApp()->shopCart
            );

            if (sizeof($orders) > 0) {
                return $this->renderOrdersPayment($orders);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'cart' => $this->getApp()->shopCart,
        ]);
    }

    protected function buildDefaultOrderForm($model)
    {
        $model->email      = $this->getUser()->email;
        $model->phone      = $this->getUser()->phone;
        $model->full_name = $this->getUser()->fullName;

        return $model;
    }

    protected function renderOrdersPayment($orders)
    {
        if (sizeof($orders) == 1) {
            $order = current($orders);

            return $this->redirect([
                    '/payment',
                    'id' => $order->bill_id,
                ]);
        }

        $this->getApp()->session->setFlash('success', \Yii::t('app/shop', 'Orders Collection Created'));

        return $this->render('orders', [
                'orders' => $orders,
            ]);
    }

    protected function createOrders($model, $cart)
    {
        $builder = $this->getCustomersBuilder();

        $attributes = $model->getAttributes();
        $builder->loadAttributes($attributes);

        if (!$builder->validate()) {
            throw new ForbiddenHttpException('Customer is blocked');
        }

        if (!$builder->save()) {
            return $model;
        }

        return $this->getOrdersManager()->createOrders(
                $cart,
                $builder->getCustomer()
            );
    }

    protected function getCustomersBuilder()
    {
        return $this
            ->getCustomersManager()
            ->createBuilder($this->getUser());
    }

    protected function getOrdersManager()
    {
        return $this->getApp()->ordersManager;
    }


    protected function getCustomersManager()
    {
        return $this->getApp()->customersManager;
    }
}
