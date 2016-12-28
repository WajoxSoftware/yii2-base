<?php
namespace wajox\yii2base\services\shop;

use wajox\yii2base\components\base\Object;

class GoodLettersMailer extends Object
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function send()
    {
        $order = $this->model->order;

        $email = $this->model->order->customer->email;
        $subject = $this->model->letter->title;

        $template = 'good_letters_mailer/email';

        $data = ['body' => $this->getBody()];

        return $this->getApp()->mailer->send($email, $subject, $template, $data);

    }

    protected function getBody()
    {
        $letter = $this->model->letter;

        $body = [
            'html' => $letter->content_html,
            'text' => $letter->content_text,
        ];

        $params = $this->getLetterParams();

        foreach ($body as $key => $bodyText) {
            foreach ($params as $param => $value) {
                $bodyText = str_replace('[' . $param . ']', $value, $bodyText);
            }

            $body[$key] = $bodyText;
        }

        return $body;
    }

    protected function getLetterParams()
    {
        $letter = $this->model->letter;
        $order = $this->model->order;
        $customer = $order->customer;
        $good = $letter->good;

        $paymentLink = \yii\helpers\Url::toRoute([
            '/payment/default/index',
            'id' => $order->bill_id,
        ], true);

        $sendPostDate = $order->isSend ? $order->statusDate : '';
        $postId = $order->eautopayOrder ? $order->eautopayOrder->eautopay_order_id : '';

        return [
            'CUSTOMER_FULLNAME' => $customer->fullName,
            'CUSTOMER_FIRSTNAME' => $customer->firstName,
            'CUSTOMER_LASTNAME' => $customer->lastName,
            'CUSTOMER_EMAIL' => $customer->email,
            'CUSTOMER_PHONE' => $customer->phone,
            'GOOD_TITLE' => $good->title,
            'ORDER_SUM' => $order->sum,
            'PAYMENT_LINK' => $paymentLink,
            'ORDER_DATE' => $order->createdDate,
            'ORDER_TIME' => $order->createdTime,
            'ORDER_SEND_DATE' => $sendPostDate,
            'ORDER_SEND_NUMBER' => $postId,
            'CUSTOMER_COUNTRY' => $customer->country,
            'CUSTOMER_REGION' => $customer->region,
            'CUSTOMER_CITY' => $customer->city,
            'CUSTOMER_POSTAL' => $customer->postalcode,
            'CUSTOMER_ADDRESS' => $customer->address,
        ];
    }
}
