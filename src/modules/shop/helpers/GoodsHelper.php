<?php
namespace wajox\yii2base\modules\shop\helpers;

use wajox\yii2base\models\User;
use wajox\yii2base\modules\shop\models\GoodPartnerProgram;
use wajox\yii2base\modules\payment\models\GoodPaymentMethod;
use wajox\yii2base\modules\payment\models\GoodDeliveryMethod;

class GoodsHelper
{
    public static function getCurrentUser()
    {
        return \Yii::$app->user->identity;
    }

    public static function getPartner($user)
    {
        if ($user->isPartner) {
            return $user->partner;
        }

        return;
    }

    public static function getFormattedPrice($good)
    {
        $deliveryPrice = self::getDeliveryPrice($good);
        $price = $good->sumRUR;

        if ($deliveryPrice > 0) {
            return $price.'(+'.$deliveryPrice.')';
        }

        return $price;
    }

    public static function getPrice($good, $user = null)
    {
        $user = $user ?: self::getCurrentUser();
        $deliveryPrice = self::getDeliveryPrice($good);
        $actualPrice = self::getPartnerPrice($good, self::getPartner($user));
        $resultPrice = $deliveryPrice + $actualPrice;

        return $resultPrice;
    }

    public static function getPartnerPrice($good, $partner = null)
    {
        if (($coupon = self::getActiveCoupon($good, $partner)) == null) {
            return $good->sum;
        }

        return $coupon->sum;
    }

    public static function getActiveCoupon($good, $partner = null)
    {
        if ($partner == null) {
            $partnerId = 0;
        } else {
            $partnerId = $partner->id;
        }

        $partnersIds = [$partnerId, 0];

        foreach ($good->coupons as $coupon) {
            if (in_array($coupon->partner_id, $partnersIds)
            ) {
                return $coupon;
            }
        }

        return;
    }

    public static function getActionCoupon($good, $partner = null)
    {
        if ($partner == null) {
            $partnerId = 0;
        } else {
            $partnerId = $partner->id;
        }

        $partnersIds = [$partnerId, 0];

        foreach ($good->coupons as $coupon) {
            if ($coupon->isAction
                && in_array($coupon->partner_id, $partnersIds)
            ) {
                return $coupon;
            }
        }

        return;
    }

    public static function isActivePaymentMethod($good, $paymentMethod)
    {
        $method = GoodPaymentMethod::findOne([
            'good_id' => $good->id,
            'payment_method' => $paymentMethod,
        ]);

        if ($method) {
            return true;
        }

        return false;
    }

    public static function isActiveDeliveryMethod($good, $deliveryMethod)
    {
        $method = GoodDeliveryMethod::findOne([
            'good_id' => $good->id,
            'delivery_method' => $deliveryMethod,
        ]);

        if ($method) {
            return true;
        }

        return false;
    }

    public static function getDeliveryPrice($good)
    {
        $method = GoodDeliveryMethod::find()->where(['good_id' => $good->id])
            ->andWhere('[[delivery_price]] > 0')
            ->orderBy('[[delivery_price]] DESC')
            ->one();

        if ($method == null) {
            return 0;
        }

        return $method->deliverySumRUR;
    }

    public static function getPartnerProgram($good, $partner = null)
    {
        $partnerId = $partner ? $partner->id : 0;

        $program = GoodPartnerProgram::find()
            ->where([
                'good_id' => $good->id,
                'partner_id' => $partnerId,
            ])->one();

        if ($program != null) {
            return $program;
        }

        $program = GoodPartnerProgram::find()
            ->where([
                'good_id' => $good->id,
                'partner_id' => 0,
            ])->one();

        return $program;
    }
}
