<?php
namespace wajox\yii2base\modules\payment\services\bill;

use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\\modules\payment\events\BillEvent;
use wajox\yii2base\components\base\Object;

class BillsManager extends Object
{
    const SYSTEM_PAYMENT = 'SystemPayments';

    public function create($data, $customer)
    {
        $model = $this->createObject(Bill::className());
        $model->load($data);
        $model->payment_method = self::SYSTEM_PAYMENT;
        $model->created_at     = time();
        $model->customer_id    = $customer->id;
        $model->user_id        = $customer->user_id;

        if ($model->saveStatusNew()) {
            $this->triggerEvent($model, BillEvent::EVENT_CREATED);
        }

        return $model;
    }

    public function paid($model, $paymentMethod = self::SYSTEM_PAYMENT)
    {
        if ($model->isPaid) {
            return false;
        }

        if ($model->isAccountUpdateDestination) {
            $balanceUpdated = $model
                ->customer
                ->user
                ->updateBalance($model->sum);

            if (!$balanceUpdated) {
                return false;
            }
        }

        $model->payment_method = $paymentMethod;
        $model->saveStatusPaid();

        $this->triggerEvent($model, BillEvent::EVENT_PAID);

        return true;
    }

    public function cancelled($model)
    {
        if (!$model->isNew) {
            return false;
        }

        $model->saveStatusCancelled();

        $this->triggerEvent($model, BillEvent::EVENT_CANCELLED);

        return true;
    }

    public function returned($model)
    {
        if (!$model->isPaid) {
            return false;
        }

        $model->saveStatusReturned();

        $this->triggerEvent($model, BillEvent::EVENT_RETURNED);

        return true;
    }

    public function triggerEvent($model, $type)
    {
        $event = $this->createObject(BillEvent::className());
        $event->bill = $model;
        
        $this
            ->getApp()
            ->eventsManager
            ->trigger(Bill::className(), $type, $event);
    }
}
