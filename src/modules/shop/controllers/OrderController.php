<?php
namespace wajox\yii2base\modules\shop\controllers;

use wajox\yii2base\models\form\OrderForm;
use wajox\yii2base\services\shop\CustomerBuilder;
use wajox\yii2base\services\shop\ShopCartManager;
use wajox\yii2base\services\order\OrdersManager;
use yii\web\ForbiddenHttpException;

class OrderController extends ApplicationController
{
    public function actionCreate($cart)
    {
        $cartManager = $this->getCartManager($cart)->loadGoods();
        $model = $this->createObject(OrderForm::className());
        $model->setGoods($cartManager->getGoods());
        
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
            $orders = $this->createOrders($model, $cartManager);

            if (sizeof($orders) > 0) {
                return $this->renderOrdersPayment($orders);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'cartManager' => $cartManager,
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
                    'id' => $order->id,
                ]);
        }

        $this->getApp()->session->setFlash('success', \Yii::t('app/shop', 'Orders Collection Created'));

        return $this->render('orders', [
                'orders' => $orders,
            ]);
    }

    protected function createOrders($model, $cartManager)
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
                $cartManager,
                $builder->getCustomer()
            );
    }

    protected function getCartManager($json)
    {
        $manager = $this->createObject(ShopCartManager::className(), [$this->getUser(), false]);

        return $manager->parseCartJson($json);
    }

    protected function getCustomersBuilder()
    {
        return $this->createObject(CustomerBuilder::className(), [$this->getUser()]);
    }

    protected function getOrdersManager()
    {
        return $this->getDependency(OrdersManager::className());
    }
}
