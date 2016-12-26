<?php
namespace wajox\yii2base\services\bill;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Bill;
use wajox\yii2base\services\events\types\BillEvent;
use wajox\yii2base\components\base\Object;

class BillsManager extends Object
{
    public function create($data, $customer)
    {
        $model = $this->createObject(Bill::className());
        $model->load($data);
        $model->payment_method = 'SystemPayments';
        $model->created_at     = time();
        $model->customer_id    = $customer->id;
        $model->user_id        = $customer->user_id;

        if ($model->updateStatus(Bill::STATUS_ID_NEW)) {
            $this->triggerEvent($model, BillEvent::EVENT_CREATED);
        }

        return $model;
    }

    public function paid($model, $payment_method = 'SystemPayments')
    {
        if ($model->isPaid) {
            return false;
        }

        if ($model->isAccountUpdateDestination) {
            $balance_updated = $model->customer->user->updateBalance($model->sum);

            if (!$balance_updated) {
                return false;
            }
        }

        $model->payment_method = $payment_method;
        $model->updateStatus(Bill::STATUS_ID_PAID);

        $this->triggerEvent($model, BillEvent::EVENT_PAID);

        return true;
    }

    public function cancelled($model)
    {
        if (!$model->isNew) {
            return false;
        }

        $model->updateStatus(Bill::STATUS_ID_CANCELLED);

        $this->triggerEvent($model, BillEvent::EVENT_CANCELLED);

        return true;
    }

    public function returned($model)
    {
        if (!$model->isPaid) {
            return false;
        }

        $model->updateStatus(Bill::STATUS_ID_RETURNED);

        $this->triggerEvent($model, BillEvent::EVENT_RETURNED);

        return true;
    }

    public function triggerEvent($model, $type)
    {
        $event = $this->createObject(BillEvent::className());
        $event->bill = $model;
        
        $this->getApp()->eventsManager->trigger(Bill::className(), $type, $event);
    }
}
