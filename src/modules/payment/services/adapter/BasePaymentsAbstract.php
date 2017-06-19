<?php
namespace wajox\yii2base\modules\payment\services\adapter;

use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\components\base\Object;

abstract class BasePaymentsAbstract extends Object
{
    public function getIsEnabled(): bool
    {
        return true;
    }

    public function getClassShort(): string
    {
        return str_replace(__NAMESPACE__.'\\', '', get_called_class());
    }

    public function getClass(): string
    {
        return get_called_class();
    }

    public function getId(): string
    {
        return $this->getClassShort();
    }

    public function getTitle(): string
    {
        return \Yii::t(
            'app/payment',
            'Payment Method ' . $this->getClassShort()
        );
    }

    public function getSettings(): array
    {
        return $this->getApp()
            ->systemPaymentSettings
            ->getSettings($this->getId());
    }

    public function getBill($id): Bill
    {
        return $this
            ->getRepository()
            ->find(Bill::className())
            ->byId($id)
            ->one();
    }

    public function payBill($id)
    {
        $bill = $this->getBill($id);

        return $this
            ->getApp()
            ->billsManager
            ->paid($bill, $this->getId());
    }

    public function errorResponse(string $message = '')
    {
        return [
          'success' => false,
          'message' => $message,
          'payment_method' => $this->getId(),
        ];
    }

    public function successResponse(string $message = '')
    {
        return [
          'success' => true,
          'message' => $message,
          'payment_method' => $this->getId(),
        ];
    }

    public function formData($bill)
    {
        $form_data = $this->getSettings();
        $form_data['bill_id'] = $bill->id;
        $form_data['description'] = $bill->paymentDestination;
        $form_data['amount'] = $bill->sum;
        $form_data['customer_id'] = $bill->customer->id;
        $form_data['customer_full_name'] = $bill->customer->fullName;
        $form_data['customer_email'] = $bill->customer->email;
        $form_data['customer_phone'] = $bill->customer->phone;
        $form_data['customer_full_address'] = $bill->customer->fullAddress;

        return $form_data;
    }

    public function hasForm(): bool
    {
        return true;
    }

    public function processPayment($action, $data)
    {
        return true;
    }

    public function attachGood($good, $params = [])
    {
        $method = $this->createObject(GoodPaymentMethod::className());
        $method->good_id = $good->id;
        $method->payment_method  = $this->getId();
        $method->save();

        $this->afterAttach($good, $params);
    }

    public function detachGood($good)
    {
        $this
            ->getRepository()
            ->deleteAll(
                GoodPaymentMethod::className(),
                [
                    'good_id' => $good->id,
                    'payment_method' => $this->getId(),
                ]
            );

        $this->afterDetach($good);
    }

    protected function afterAttach($good, $params)
    {
        ;
    }

    protected function afterDetach($good)
    {
        ;
    }
}
