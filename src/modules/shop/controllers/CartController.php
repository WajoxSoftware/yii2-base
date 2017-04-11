<?php
namespace wajox\yii2base\modules\shop\controllers;

use wajox\yii2base\modules\shop\services\ShopCartManager;

class CartController extends ApplicationController
{
    public function actionIndex()
    {
        $cart = $this->getManager()->getCart();

        return $this->render('index', [
            'cart' => $cart,
        ]);
    }

    public function actionUpdate($goodId, $count)
    {
        $this->getManager()->addItem($goodId, $count);

        $this->redirect(['index']);
    }

    public function actionDelete($goodId, $count)
    {
        $this->getManager()->dropItems();

        $this->redirect(['index']);
    }

    protected function getManager()
    {
        return $this->createObject(ShopCartManager::className(), [$this->getUser()]);
    }
}
