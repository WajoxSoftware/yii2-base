<?php
namespace wajox\yii2base\modules\payment\services\adapter;

class YandexPayments extends BasePaymentsAbstract
{
    public function getSettings(): array
    {
        return [
            'shopId' => $this->getApp()->settings->get('app_payments_YandexPayments_shopId'),
            'scid' => $this->getApp()->settings->get('app_payments_YandexPayments_scid'),
            'shopPass' => $this->getApp()->settings->get('app_payments_YandexPayments_shopPass'),
        ];
    }

    public function getIsEnabled(): bool
    {
        return $this->getApp()->settings->get('app_payments_YandexPayments_on');
    }

    public function processPayment(string $action, array $data = [])
    {
        if (!in_array($action, ['process', 'checkOrder', 'paymentAviso'])) {
            return;
        }

        $data['action'] = isset($data['action']) ? $data['action'] : $action;

        $settings = $this->getSettings();

        $str = $data['action']
            . ';' . $data['orderSumAmount']
            . ';' . $data['orderSumCurrencyPaycash']
            . ';' . $data['orderSumBankPaycash']
            . ';' . $data['shopId']
            . ';' . $data['invoiceId']
            . ';' . $data['customerNumber']
            . ';' . $settings['shopPass'];

        $md5 = strtoupper(md5($str));
        if ($md5 != strtoupper($data['md5'])) {
            $responseText = $this->responseText($data['action'], $data['invoiceId'], 1);

            return $this->errorResponse($responseText);
        }

        if ($data['action'] == 'checkOrder') {
            $responseText = $this->responseText('checkOrder', $data['invoiceId'], 0);

            return $this->successResponse($responseText);
        }

        if ($data['action'] == 'paymentAviso') {
            if (!$this->payBill($data['orderNumber'])) {
                $responseText = $this->responseText($data['action'], $data['invoiceId'], 100);

                return $this->errorResponse($responseText);
            }

            $responseText = $this->responseText($data['action'], $data['invoiceId'], 0);

            return $this->successResponse($responseText);
        }

        return $this->errorResponse('');
    }

    public function responseText(string $functionName, int $invoiceId, int $result_code, string $message = '')
    {
        $settings = $this->getSettings();
        $performedDatetime = date("Y-m-d") . "T"
                            . date("H:i:s")
                            . ".000" . date("P");

        header("HTTP/1.0 200");
        header("Content-Type: application/xml");

        $response = '<?xml version="1.0" encoding="UTF-8"?><'.$functionName.'Response performedDatetime="'.$performedDatetime.
            '" code="'.$result_code.'"'.($message != '' ? ' message="'.$message.'"' : '').' invoiceId="'.$invoiceId.'" shopId="'.$settings['shopId'].'"/>';

        \Yii::info($response);

        return $response;
    }
}
