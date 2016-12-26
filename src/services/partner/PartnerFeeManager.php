<?php

namespace wajox\yii2base\services\partner;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;
use wajox\yii2base\models\PartnerFee;
use wajox\yii2base\helpers\GoodsHelper;
use wajox\yii2base\components\base\Object;

class PartnerFeeManager extends Object
{
    public function confirm($fee)
    {
        if (!$fee->isNew && !$fee->isCancelled) {
            return false;
        }

        if ($fee->partner->user->updateBalance($fee->sum)
            && $fee->updateStatus(PartnerFee::STATUS_ID_PAID)
        ) {
            return true;
        }

        return false;
    }

    public function cancel($fee)
    {
        if ($fee->isPaid) {
            return $this->cancelConfirmed($fee);
        }

        if (!$fee->isNew) {
            return false;
        }

        return $fee->updateStatus(PartnerFee::STATUS_ID_CANCELLED);
    }

    public function cancelConfirmed($fee)
    {
        if (!$fee->isPaid) {
            return false;
        }

        if ($fee->partner->user->updateBalance($fee->sum * -1)
            && $fee->updateStatus(PartnerFee::STATUS_ID_CANCELLED)
        ) {
            return true;
        }

        return false;
    }

    public function dropOrder($order)
    {
        $partnerFees = PartnerFee::find()->where(['order_id' => $order->id]);

        foreach ($partnerFees->each() as $partnerFee) {
            $this->canccel($partnerFee);
        }
    }

    public function processOrder($order)
    {
        $partner_level_1 = null;
        $partner_level_2 = null;

        $customer = $order->customer;

        if ($customer->partner) {
            $partner_level_1 = $customer->partner;
        }

        if ($partner_level_1 && $partner_level_1->parentPartner) {
            $partner_level_2 = $partner_level_1->parentPartner;
        }

        $this->saveFees($order, $partner_level_1, $partner_level_2);
    }

    public function saveFees($order, $partner_level_1, $partner_level_2)
    {
        $fee_sum_1 = 0;
        $fee_sum_2 = 0;

        foreach ($order->goods as $good) {
            if ($partner_level_1) {
                $program = GoodsHelper::getPartnerProgram($good, $partner_level_1);
                if ($program) {
                    $fee_sum_1 = $program->fee_1_level;
                }
            }

            if ($partner_level_2) {
                $program = GoodsHelper::getPartnerProgram($good, $partner_level_2);
                if ($program) {
                    $fee_sum_2 = $program->fee_2_level;
                }
            }
        }

        if ($fee_sum_1 > 0) {
            $fee = $this->createObject(PartnerFee::className());
            $fee->partner_id = $partner_level_1->id;
            $fee->sum = $fee_sum_1;
            $fee->order_id = $order->id;
            $fee->status_id = PartnerFee::STATUS_ID_NEW;
            $fee->created_at = time();
            $fee->save();
        }

        if ($fee_sum_2 > 0) {
            $fee = $this->createClass(PartnerFee::className());
            $fee->partner_id = $partner_level_2->id;
            $fee->sum = $fee_sum_2;
            $fee->order_id = $order->id;
            $fee->status_id = PartnerFee::STATUS_ID_NEW;
            $fee->created_at = time();
            $fee->save();
        }
    }
}
