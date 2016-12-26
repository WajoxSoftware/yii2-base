<?php
namespace wajox\yii2base\models;

class PartnerFee extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_PAID = 101;
    const STATUS_ID_CANCELLED = 102;

    public static function tableName()
    {
        return 'partner_fee';
    }

    public function rules()
    {
        return [
            [['order_id', 'partner_id', 'created_at', 'status_id', 'sum'], 'required'],
            [['order_id', 'partner_id', 'created_at', 'status_id'], 'integer'],
            [['sum'], 'number'],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'order_id' => \Yii::t('app/attributes', 'Order ID'),
            'partner_id' => \Yii::t('app/attributes', 'Partner ID'),
            'sum' => \Yii::t('app/attributes', 'Sum'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Partner Fee Status New'),
            self::STATUS_ID_PAID => \Yii::t('app/attributes', 'Partner Fee Status Paid'),
            self::STATUS_ID_CANCELLED => \Yii::t('app/attributes', 'Partner Fee Status Cancelled'),
        ];
    }

    public static function getActiveStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Partner Fee Status New'),
            self::STATUS_ID_PAID => \Yii::t('app/attributes', 'Partner Fee Status Paid'),
        ];
    }

    public function getStatus()
    {
        return $this::getStatusIdList()[$this->status_id];
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

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function updateStatus($new_status)
    {
        $this->status_id = $new_status;

        return $this->save();
    }

    public function getSumRUR()
    {
        return number_format($this->sum, 2);
    }
}
