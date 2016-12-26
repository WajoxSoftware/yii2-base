<?php
namespace wajox\yii2base\modules\shop\traits;

use wajox\yii2base\helpers\GoodsHelper;

trait CouponTrait
{
    protected function renderCoupon($good)
    {
        $coupon = $this->getCoupon($good);

        if ($coupon == null) {
            return;
        }

        if ($coupon->isActive) {
            return;
        }

        if ($coupon->isFinishRedirect) {
            return $this->redirect($coupon->redirectUrl);
        }

        if ($coupon->isFinishGood) {
            return $this->redirect($coupon->redirectGood->url);
        }

        if ($coupon->isFinishMessage) {
            return $this->render('message', ['message' => $coupon->finishedMessage]);
        }

        return;
    }

    protected function getCoupon($good)
    {
        return GoodsHelper::getActionCoupon(
            $good,
            \Yii::$app->visitor->partner
        );
    }
}
