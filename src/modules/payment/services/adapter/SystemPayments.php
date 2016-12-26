<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class SystemPayments extends BasePaymentsAbstract
{
    public function formData($bill)
    {
        return [];
    }

    public function processPayment($action, $data)
    {
        return $this->errorResponse();
    }
}
