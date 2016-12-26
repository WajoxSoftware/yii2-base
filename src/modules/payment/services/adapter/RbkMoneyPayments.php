<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class RbkMoneyPayments extends BasePaymentsAbstract
{
    public function getSettings()
    {
        return [
            'id' => $this->getApp()->settings->get('app_payments_RbkMoneyPayments_id'),
            'key' => $this->getApp()->settings->get('app_payments_RbkMoneyPayments_key'),
        ];
    }

    public function getIsEnabled()
    {
        return $this->getApp()->settings->get('app_payments_RbkMoneyPayments_on');
    }

    public function processPayment($action, $data)
    {
        if ($action != 'process') {
            return;
        }

        $settings = $this->getSettings();

        $rbkmoneyid = $settings['id'];
        $rbkmoneykey = $settings['key'];

        \Yii::trace(json_encode($data));
        \Yii::trace(json_encode($settings));

        extract($data, EXTR_SKIP);

        if ($paymentStatus != 5) {
            return $this->successResponse();
        }

        if (empty($hash)) {
            return $this->errorResponse();
        }

        $keys = [
            $eshopId,
            $orderId,
            $serviceName,
            $eshopAccount,
            $recipientAmount,
            $recipientCurrency,
            $paymentStatus,
            $userName,
            $userEmail,
            $paymentData,
            $rbkmoneykey,
        ];

        $str = implode('::', $keys);

        $crc = strtolower($hash);

        if ($crc != md5($str)) {
            return $this->errorResponse();
        }

        $bill_id = $orderId;
        $sum = $recipientAmount;

        if (!$this->payBill($bill_id)) {
            return $this->errorResponse();
        }

        return $this->successResponse('OK');
    }
}
