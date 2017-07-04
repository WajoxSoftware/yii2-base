<?php
namespace wajox\yii2base\modules\shop\controllers;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\services\traffic\ClicksManager;
use yii\web\NotFoundHttpException;

class OrderFormsController extends ApplicationController
{
    use \wajox\yii2base\modules\shop\traits\CouponTrait;

    public function actionGood(string $url)
    {
        $this->getClicksManager()->save();

        $good = $this->findGood($url);

        if (($result = $this->renderCoupon($good)) !== null) {
            return $result;
        }

        $this
            ->getApp()
            ->shopCart
            ->dropItems()
            ->addItem($good->id, 1);

        return $this->redirect([
                '/shop/order/create',
                'tag' => $good->url,
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
