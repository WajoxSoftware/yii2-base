<?php

namespace wajox\yii2base\services\wajox_software;

use wajox\yii2base\components\base\component;
use wajox\yii2base\models\Order;
use wajox\yii2base\models\EautopayOrder;
use wajox\yii2base\models\Customer;

class EAutopayOrderManager extends Component
{
    public $userApiKey = null;
    public $customerApiKey = null;
    public $apiUrl = null;

    public function __construct($params = [])
    {
        $this->userApiKey = \Yii::$app->settings->get('app_Eautopay_userapikey');
        $this->customerApiKey = \Yii::$app->settings->get('app_Eautopay_customerapikey');
        $this->apiUrl = \Yii::$app->settings->get('app_Eautopay_apiurl');
    }

    public function getStatus($status)
    {
        $status_list = [
          'cancelled' => Order::STATUS_ID_CANCELLED,
          'in_hands_paid' => Order::STATUS_ID_PAID,
          'refused' => Order::STATUS_ID_CANCELLED,
          'delivered_paid' => Order::STATUS_ID_PAID,
        ];

        if (!isset($status_list[$status])) {
            return 'new';
        }

        return $status_list[$status];
    }

    public function getDeliveryStatus($status)
    {
        $status_list = [
          'cancelled' => Order::DELIVERY_STATUS_ID_RETURNED,
          'in_hands_paid' => Order::DELIVERY_STATUS_ID_DELIVERED,
          'refused' => Order::DELIVERY_STATUS_ID_RETURNED,
          'delivered_unpaid' => Order::DELIVERY_STATUS_ID_DELIVERED,
          'delivered_paid' => Order::DELIVERY_STATUS_ID_DELIVERED,
          'in_hands_unpaid' => Order::DELIVERY_STATUS_ID_DELIVERED,
          'wanted' => Order::DELIVERY_STATUS_ID_UNDELIVERED,
          'absence' => Order::DELIVERY_STATUS_ID_UNDELIVERED,
          'returned' => Order::DELIVERY_STATUS_ID_RETURNED,
        ];

        if (!isset($status_list[$status])) {
            return Order::DELIVERY_STATUS_ID_WAITING;
        }

        return $status_list[$status];
    }

    public function addOrder($order)
    {
        foreach ($order->goods as $good) {
            $deliveryMethod = $good->getDeliveryMethods()
                ->andWhere(['delivery_method' => 'CodDelivery'])
                ->one();

            $goods[] = [
                'good_id' => $deliveryMethod->extra['delivery_good_id'], // идентификатор товара
                'cost' => $good->sum, // цена товара
                'quantity' => 1, // количество товара
              ];
        }

        $customer = $order->customer;

        $orderData = [
            'customer_api_key' => $this->customerApiKey,
            'order' => [
                'customer' => [
                    'surname' => $customer->lastName, // фамилия
                    'given_name' => $customer->firstMame, // имя
                    'address' => $customer->fullAddress,
                    'email' => $customer->email, // email
                    'phone' => $customer->phone, // телефон
                ],
                'credentials' => [
                    'created' => date('%Y-%m-%d %h:%i:%s', $order->status_at), // дата заказа
                    'amount' => $order->sum,
                    'delivery_cost' => $order->delivery_sum,
                ],
                'basket' => $goods,
            ],
        ];

        $resource = $this->apiUrl.$this->userApiKey.'/orders';
        $response = $this->sendRequest($resource, $orderData, 'POST');

        if (property_exists($response, 'error')) {
            return false;
        }

        $eautopay_order = $this->createObject(EautopayOrder::className());
        $eautopay_order->order_id = $order->id;
        $eautopay_order->eautopay_order_id = $response->order->order_id;
        $eautopay_order->status = $response->order_status;
        $eautopay_order->status_at = time();

        return $eautopay_order->save();
    }

    public function synchronize()
    {
        $time = time() - 3600 * 2;
        $except_status = ['delivered_paid', 'returned', 'cancelled'];

        $q = $this
            ->getRepository()
            ->find(EautopayOrder::className())
            ->where('[[status_at]] < :time', ['time' => $time])
            ->andWhere(['not in', 'status', $except_status])
            ->orderBy('[[status_at]] ASC')
            ->limit(100);

        foreach ($q as $ea_order) {
            $resource = $this->apiUrl.$this->userApiKey.'/orders/'.$ea_order->eautopay_order_id;
            $data = ['customer_api_key' => $this->customerApiKey];
            $response = $this->sendRequest($resource, $data);
            if ($response->order->status != $ea_order->status) {
                $ea_order->status = $response->order->status;
                $ea_order->status_at = time();
                $ea_order->save();

                $this->updateOrderStatus($ea_order);
            }
        }
    }

    public function updateOrderStatus($eautopay_order)
    {
        $order = $eautopay_order->order;
        $bill = $order->bill;

        $order->status_id = $this->getStatus($eautopay_order->status);
        $order->delivery_status_id = $this->getDeliveryStatus($eautopay_order->status);
        $bill->status_id = $order->status;
        $bill->save();
        $order->save();
    }

    public function sendRequest($resource, $data = [], $method = 'GET')
    {
        $ch = \curl_init($resource);
        \curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (count($data) > 0) {
            $data_string = json_encode($data);
            \curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        }

        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: '.strlen($data_string),
            ]);

        $result = \curl_exec($ch);

        return json_decode($result);
    }
}
