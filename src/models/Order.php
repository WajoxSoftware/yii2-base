<?php
namespace wajox\yii2base\models;

class Order extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;
    use \wajox\yii2base\traits\StatusAtTrait;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_PAID = 101;
    const STATUS_ID_CANCELLED = 102;
    const STATUS_ID_RETURNED = 103;

    const DELIVERY_STATUS_ID_WAITING = 100;
    const DELIVERY_STATUS_ID_PREPARED = 101;
    const DELIVERY_STATUS_ID_SEND = 102;
    const DELIVERY_STATUS_ID_DELIVERED = 103;
    const DELIVERY_STATUS_ID_UNDELIVERED = 104;
    const DELIVERY_STATUS_ID_RETURNED = 105;

    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['delivery_method', 'saler_comment'], 'filter', 'filter' => 'strip_tags'],
            [['saler_comment'], 'filter', 'filter' => 'htmlentities'],
            [['delivery_method', 'saler_comment'], 'filter', 'filter' => 'trim'],
            [['bill_id', 'customer_id', 'user_id', 'status_at', 'created_at', 'status_id', 'delivery_status_id'], 'integer'],
            [['sum', 'delivery_sum'], 'number'],
            [['bill_id', 'customer_id', 'user_id', 'sum', 'delivery_sum', 'status_id', 'delivery_status_id'], 'required'],
            [['delivery_method'], 'string', 'max' => 255],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
            ['delivery_status_id', 'in', 'range' => array_keys($this::getDeliveryStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'Order ID'),
            'bill_id' => \Yii::t('app/attributes', 'Bill ID'),
            'customer_id' => \Yii::t('app/attributes', 'Customer ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'sum' => \Yii::t('app/attributes', 'Sum'),
            'delivery_sum' => \Yii::t('app/attributes', 'Delivery Sum'),
            'delivery_method' => \Yii::t('app/attributes', 'Delivery Method'),
            'saler_comment' => \Yii::t('app/attributes', 'Order Saler Comment'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'delivery_status_id' => \Yii::t('app/attributes', 'Delivery Status'),
            'status' => \Yii::t('app/attributes', 'Status'),
            'deliveryStatus' => \Yii::t('app/attributes', 'Delivery Status'),
            'status_at' => \Yii::t('app/attributes', 'Status At'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public function getSumRUR()
    {
        return $this->sum;
    }

    public function getDeliverySumRUR()
    {
        return $this->delivery_sum;
    }

    public function getStatus()
    {
        return $this::getStatusIdList()[$this->status_id];
    }

    public function getDeliveryStatus()
    {
        return $this::getDeliveryStatusIdList()[$this->delivery_status_id];
    }

    public function getIsNew()
    {
        return $this->status_id == self::STATUS_ID_NEW;
    }

    public function getIsPaid()
    {
        return $this->status_id == self::STATUS_ID_PAID;
    }

    public function getIsCancelled()
    {
        return $this->status_id == self::STATUS_ID_CANCELLED;
    }

    public function getIsMoneyReturned()
    {
        return $this->status == self::STATUS_ID_RETURNED;
    }

    public function getIsDeliveryWaiting()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_WAITING;
    }

    public function getIsPrepared()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_PREPARED;
    }

    public function getIsSend()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_SEND;
    }

    public function getIsUndelivered()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_UNDELIVERED;
    }

    public function getIsDelivered()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_DELIVERED;
    }

    public function getIsReturned()
    {
        return $this->delivery_status_id == self::DELIVERY_STATUS_ID_RETURNED;
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Order Status New'),
            self::STATUS_ID_PAID => \Yii::t('app/attributes', 'Order Status Paid'),
            self::STATUS_ID_CANCELLED => \Yii::t('app/attributes', 'Order Status Cancelled'),
            self::STATUS_ID_RETURNED => \Yii::t('app/attributes', 'Order Status Money Returned'),
        ];
    }

    public static function getDeliveryStatusIdList()
    {
        return [
            self::DELIVERY_STATUS_ID_WAITING => \Yii::t('app/attributes', 'Order Delivery Status Waiting'),
            self::DELIVERY_STATUS_ID_PREPARED => \Yii::t('app/attributes', 'Order Delivery Status Prepared'),
            self::DELIVERY_STATUS_ID_SEND => \Yii::t('app/attributes', 'Order Delivery Status Send'),
            self::DELIVERY_STATUS_ID_DELIVERED => \Yii::t('app/attributes', 'Order Delivery Status Delivered'),
            self::DELIVERY_STATUS_ID_UNDELIVERED => \Yii::t('app/attributes', 'Order Delivery Status Undelivered'),
            self::DELIVERY_STATUS_ID_RETURNED => \Yii::t('app/attributes', 'Order Delivery Status Returned'),
        ];
    }

    //relations
    public function getOrderGoods()
    {
        return $this->hasMany(OrderGood::className(), ['order_id' => 'id']);
    }

    public function getGoods()
    {
        return $this->hasMany(Good::className(), ['id' => 'good_id'])
        ->viaTable(OrderGood::tableName(), ['order_id' => 'id']);
    }

    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatuses()
    {
        return $this->hasMany(OrderStatus::className(), ['order_id' => 'id']);
    }

    public function getPartnerFees()
    {
        return $this->hasMany(PartnerFee::className(), ['order_id' => 'id']);
    }

    public function getEautopayOrder()
    {
        return $this->hasOne(EautopayOrder::className(), ['id' => 'id']);
    }

    public function updateStatus($new_status_id, $new_delivery_status_id = null, $save = true)
    {
        if ($new_delivery_status_id == null) {
            $new_delivery_status_id = $this->delivery_status_id;
        }

        $this->status_id = $new_status_id;
        $this->delivery_status_id = $new_delivery_status_id;
        $this->status_at = time();

        if (!$save) {
            return true;
        }

        if ($this->isNewRecord && !$this->save()) {
            return false;
        }

        if (!$this->createNewStatus($new_status_id, $new_delivery_status_id)
        ) {
            return false;
        }

        return $this->save();
    }

    public function updateDeliveryStatus($new_delivery_status_id)
    {
        if (!$this->createNewDeliveryStatus($new_delivery_status_id)) {
            return false;
        }

        $this->delivery_status_id = $new_delivery_status_id;
        $this->delivery_status_at = time();

        return $this->save();
    }

    public function isOwner($user_id)
    {
        if ($this->user_id == $user_id) {
            return true;
        }

        if ($this->customer == null) {
            return false;
        }

        if ($this->customer->user_id != $user_id) {
            return false;
        }

        return true;
    }

    protected function createNewStatus($new_status_id, $new_delivery_status_id = null)
    {
        if ($new_delivery_status_id == null) {
            $new_delivery_status_id = $this->delivery_status_id;
        }

        $status = $this->createObject(OrderStatus::className());
        $status->order_id = $this->id;
        $status->created_at = time();
        $status->delivery_status_id = $new_delivery_status_id;
        $status->status_id = $new_status_id;

        return $status->save();
    }

    protected function createNewDeliveryStatus($new_delivery_status_id)
    {
        $status = $this->createObject(OrderStatus::className());
        $status->order_id = $this->id;
        $status->created_at = time();
        $status->delivery_status_id = $new_delivery_status_id;
        $status->status_id = $this->status_id;

        return $status->save();
    }
}
