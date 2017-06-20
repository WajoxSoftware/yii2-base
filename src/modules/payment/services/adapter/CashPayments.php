<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class CashPayments extends BasePaymentsAbstract
{
    public function hasForm(): bool
    {
        return false;
    }

    public function processPayment(string $action, array $data = [])
    {
        return $this->errorResponse();
    }

    public function getIsEnabled(): bool
    {
        return $this->getApp()->settings->get('app_payments_CashPayments_on');
    }
}
