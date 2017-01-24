<?php
namespace wajox\yii2base\models\query;

use wajox\yii2base\components\db\ActiveQuery;
use wajox\yii2base\modules\payment\models\Bill;

class BillQuery extends ActiveQuery
{
    public function byStatusId(int $statusId): BillQuery
    {
        return $this->where([
            'status_id' => (int) $statusId,
        ]);
    }

    public function byCustomerId(int $customerId): BillQuery
    {
        return $this->where([
            'customer_id' => (int) $customerId,
        ]);
    }

    public function byDestinationId(int $destinationId): BillQuery
    {
        return $this->where([
            'payment_destination_id' => (int) $destinationId,
        ]);
    }

    public function accountPayment(): BillQuery
    {
        return $this->byDestinationId(
                Bill::DESTINATION_ID_ACCOUNT
            );
    }

    public function orderPayment(): BillQuery
    {
        return $this->byDestinationId(
                Bill::DESTINATION_ID_ORDER
            );
    }

    public function byOrderId(int $orderId): BillQuery
    {
        return $this->where([
            'order_id' => (int) $orderId,
        ]);
    }
}
