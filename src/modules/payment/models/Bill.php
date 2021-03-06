<?php
namespace wajox\yii2base\modules\payment\models;

use wajox\yii2base\models\User;
use wajox\yii2base\modules\payment\models\query\BillQuery;

class Bill extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;
    use \wajox\yii2base\traits\StatusAtTrait;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_PAID = 101;
    const STATUS_ID_CANCELLED = 102;
    const STATUS_ID_RETURNED = 103;

    const DESTINATION_ID_ACCOUNT = 100;
    const DESTINATION_ID_ORDER = 101;

    public static function tableName()
    {
        return 'bill';
    }

    public function rules()
    {
        return [
            [['sum', 'customer_id', 'user_id', 'status_at', 'created_at'], 'required'],
            [['customer_id', 'user_id', 'status_at', 'created_at', 'payment_destination_id', 'status_id'], 'integer'],
            [['sum'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['sum'], 'double'],
            [['payment_method', 'payment_destination_id', 'status_at', 'created_at'], 'required'],
            [['payment_method'], 'filter', 'filter' => 'strip_tags'],
            [['payment_method'], 'filter', 'filter' => 'htmlentities'],
            [['payment_method'], 'filter', 'filter' => 'trim'],
            [['payment_method'], 'string', 'max' => 255],
            [['status_id'], 'in', 'range' => array_keys($this::getStatusIdList())],
            [['payment_destination_id'], 'in', 'range' => array_keys($this::getPaymentDestinationIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'Bill ID'),
            'customer_id' => \Yii::t('app/attributes', 'User ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'sum' => \Yii::t('app/attributes', 'Sum'),
            'payment_method' => \Yii::t('app/attributes', 'Bill Payment Method'),
            'payment_destination_id' => \Yii::t('app/attributes', 'Bill Payment Destination'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'status' => \Yii::t('app/attributes', 'Status'),
            'status_at' => \Yii::t('app/attributes', 'Status At'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function find()
    {
        return self::createObject(
            BillQuery::className(),
            [get_called_class()]
        );
    }

    public function getIsNew(): bool
    {
        return $this->status_id == self::STATUS_ID_NEW;
    }

    public function getIsPaid(): bool
    {
        return $this->status_id == self::STATUS_ID_PAID;
    }

    public function getIsCancelled(): bool
    {
        return $this->status_id == self::STATUS_ID_CANCELLED;
    }

    public function getIsWithOrder(): bool
    {
        return $this->order != null;
    }

    public function saveStatusNew(): bool
    {
        return $this->updateStatus(self::STATUS_ID_NEW);
    }

    public function saveStatusPaid(): bool
    {
        return $this->updateStatus(self::STATUS_ID_PAID);
    }

    public function saveStatusCancelled(): bool
    {
        return $this->updateStatus(self::STATUS_ID_CANCELLED);
    }

    public function saveStatusReturned(): bool
    {
        return $this->updateStatus(self::STATUS_ID_RETURNED);
    }

    public static function getStatusIdList(): array
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Bill Status New'),
            self::STATUS_ID_PAID => \Yii::t('app/attributes', 'Bill Status Paid'),
            self::STATUS_ID_CANCELLED => \Yii::t('app/attributes', 'Bill Status Cancelled'),
            self::STATUS_ID_RETURNED => \Yii::t('app/attributes', 'Bill Status Returned'),
        ];
    }

    public function getStatus(): string
    {
        $statusList = self::getStatusIdList();

        return $statusList[$this->status_id];
    }

    public static function getPaymentDestinationIdList(): array
    {
        return [
            self::DESTINATION_ID_ACCOUNT => \Yii::t(
                'app/attributes',
                'Bill Payment Destination Account'
            ),
            self::DESTINATION_ID_ORDER => \Yii::t(
                'app/attributes',
                'Bill Payment Destination Order'
            ),
        ];
    }

    public function getPaymentDestination(): string
    {
        $list = self::getPaymentDestinationIdList();

        if (isset($list[$this->payment_destination_id])) {
            return $list[$this->payment_destination_id] . ' #' . $this->id;
        }
    }

    public function getIsAccountUpdateDestination(): string
    {
        return $this->payment_destination_id == self::DESTINATION_ID_ACCOUNT;
    }

    public function getSumRUR()
    {
        return number_format($this->sum, 2);
    }

    public function getPaymentMethod(): string
    {
        return \Yii::t(
            'app/payment',
            'Payment Method ' . $this->payment_method
        );
    }
    
    //relations
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['bill_id' => 'id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function isOwner(int $userId): bool
    {
        if ($this->user_id == $userId) {
            return true;
        }

        if ($this->customer == null) {
            return false;
        }

        if ($this->customer->user_id != $userId) {
            return false;
        }

        return true;
    }

    protected function updateStatus(int $newStatusId): bool
    {
        $this->status_id = $newStatusId;
        $this->status_at = time();

        return $this->save();
    }
}
