<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class PaypalPayments extends BasePaymentsAbstract
{
    public function getSettings(): array
    {
        return [
            'login' => $this->getApp()->settings->get('app_payments_PaypalPayments_login'),
        ];
    }

    public function getIsEnabled(): bool
    {
        return $this->getApp()->settings->get('app_payments_PaypalPayments_on');
    }

    public function formData($bill)
    {
        $settings = $this->getSettings();

        if ($settings == null) {
            return [];
        }

        $form_data = parent::formData($bill);

        return $form_data;
    }

    public function processPayment($action, $data)
    {
        if ($action != 'process') {
            return;
        }

        if ((empty($data['payment_status']))
         || (empty($data['item_number']))
         || (empty($data['mc_gross']))
        ) {
            return $this->errorResponse();
        }

        if ($data['payment_status'] != 'Completed'
            && $data['payment_status'] != 'Pending'
        ) {
            return $this->errorResponse();
        }

        $bill_id = $data['item_number'];
        $sum = $data['mc_gross'];

        if (!$this->payBill($bill_id)) {
            return $this->errorResponse();
        }

        return $this->successResponse();
    }
}
