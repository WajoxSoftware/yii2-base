<?php
namespace wajox\yii2base\modules\shop\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\models\Good;
use wajox\yii2base\services\traffic\ClicksManager;

class OrderFormsController extends ApplicationController
{
    use \wajox\yii2base\modules\shop\traits\CouponTrait;

    public function actionGood($url)
    {
        $this->getClicksManager()->save();

        $good = $this->findGood($url);

        if (($result = $this->renderCoupon($good)) !== null) {
            return $result;
        }

        $cart = json_encode([
                'items' => [
                    [
                        'id' => $good->id,
                        'count' => 1,
                    ],
                ],
            ]);

        return $this->redirect([
                '/shop/order/create',
                'cart' => $cart,
            ]);
    }

    protected function findGood($url)
    {
        $good = $this
            ->getRepository()
            ->find(Good::className())
            ->byUrl($url)
            ->one();

        if ($good != null) {
            return $good;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getClicksManager()
    {
        return $this->getDependency(ClicksManager::className());
    }
}
