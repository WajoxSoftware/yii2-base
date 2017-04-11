<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class InterkassaPayments extends BasePaymentsAbstract
{
    public function getSettings(): array
    {
        return [
            'id' => $this->getApp()->settings->get('app_payments_InterkassaPayments_id'),
            'key' => $this->getApp()->settings->get('app_payments_InterkassaPayments_key'),
        ];
    }

    public function getIsEnabled(): bool
    {
        return $this->getApp()->settings->get('app_payments_InterkassaPayments_on');
    }

    public function processPayment($action, $data)
    {
        if ($action != 'process') {
            return;
        }

        $settings = $this->getSettings();
        $interkassaid = $settings['id'];
        $interkassakey = $settings['key'];

        extract($data, EXTR_SKIP);

        if (empty($ik_sign_hash)) {
            return $this->errorResponse();
        }

        $str = "$interkassaid:$ik_payment_amount:$ik_payment_id:$ik_paysystem_alias"
      .":$ik_baggage_fields:success:$ik_trans_id:$ik_currency_exch:$ik_fees_payer:$interkassakey";
        $crc = strtolower($ik_sign_hash);

        if ($crc != md5($str)) {
            return $this->errorResponse();
        }

        $bill_id = $ik_payment_id;
        $sum = $ik_payment_amount;
        $payment_method = $this->getId();

        if (!$this->payBill($bill_id)) {
            return $this->errorResponse();
        }

        return $this->successResponse();
    }
}
