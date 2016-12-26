<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class RobokassaPayments extends BasePaymentsAbstract
{
    public function getSettings()
    {
        return [
            'login' => $this->getApp()->settings->get('app_payments_RobokassaPayments_login'),
            'pass1' => $this->getApp()->settings->get('app_payments_RobokassaPayments_pass1'),
            'pass2' => $this->getApp()->settings->get('app_payments_RobokassaPayments_pass2'),
        ];
    }

    public function getIsEnabled()
    {
        return $this->getApp()->settings->get('app_payments_RobokassaPayments_on');
    }

    public function formData($bill)
    {
        $settings = $this->getSettings();

        if ($settings == null) {
            return [];
        }

        $crc_data = array($settings['login'], $bill->sum, $bill->id, $settings['pass1']);

        $form_data = parent::formData($bill);
        $form_data['crc'] = md5(implode(':', $crc_data));

        return $form_data;
    }

    public function processPayment($action, $data)
    {
        if ($action != 'process') {
            return;
        }

        $settings = $this->getSettings();
        $roboxpass2 = $settings['pass2'];

        extract($data, EXTR_SKIP);

        if (empty($crc)) {
            return $this->errorResponse();
        }

        $str = "$out_summ:$inv_id:$roboxpass2";

        if (!is_numeric($inv_id)) {
            return $this->errorResponse();
        }

        $crc = strtolower($crc);

        if ($crc != md5($str)) {
            return $this->errorResponse();
        }

        $bill_id = $inv_id;
        $sum = $out_summ;

        if (!$this->payBill($bill_id)) {
            return $this->errorResponse();
        }

        return $this->successResponse("OK$inv_id\n");
    }
}
