<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class CodPayments extends BasePaymentsAbstract
{
    public function hasForm()
    {
        return false;
    }

    public function processPayment($action, $data)
    {
        return $this->errorResponse();
    }

    public function getIsEnabled()
    {
        return $this->getApp()->settings->get('app_payments_CodPayments_on');
    }
}
