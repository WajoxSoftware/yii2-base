<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class ZPaymentPayments extends BasePaymentsAbstract
{
    public function getSettings(): array
    {
        return [
            'id' => $this->getApp()->settings->get('app_payments_ZPaymentPayments_id'),
            'key' => $this->getApp()->settings->get('app_payments_ZPaymentPayments_key'),
        ];
    }

    public function getIsEnabled(): bool
    {
        return $this->getApp()->settings->get('app_payments_ZPaymentPayments_on');
    }

    public function processPayment(string $action, array $data = [])
    {
        if ($action != 'process') {
            return;
        }

        $settings = $this->getSettings();
        $zpayid = $settings['id'];
        $zpkey = $settings['key'];

        \Yii::trace(json_encode($data));
        \Yii::trace(json_encode($settings));
        
        extract($data, EXTR_SKIP);

        if (empty($LMI_HASH)) {
            return $this->errorResponse();
        }

        $str = "{$zpayid}{$LMI_PAYMENT_AMOUNT}{$LMI_PAYMENT_NO}{$LMI_MODE}{$LMI_SYS_INVS_NO}"
      ."{$LMI_SYS_TRANS_NO}{$LMI_SYS_TRANS_DATE}{$zpkey}{$LMI_PAYER_PURSE}{$LMI_PAYER_WM}";

        $LMI_HASH = strtolower($LMI_HASH);

        if ($LMI_HASH != md5($str)) {
            return $this->errorResponse('ERR: ');
        }

        $bill_id = $LMI_PAYMENT_NO;
        $sum = $LMI_PAYMENT_AMOUNT;

        if (!$this->payBill($bill_id)) {
            return $this->errorResponse('ERR: ');
        }

        return $this->successResponse('YES');
    }
}
