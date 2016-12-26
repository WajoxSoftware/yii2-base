<?php
namespace wajox\yii2base\models;

class Payment extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const DESTINATION_ID_TRANSACTION = 100;
    const DESTINATION_ID_MONEY_BACK = 101;
    const DESTINATION_ID_PARTNER_FEE = 102;

    public static function tableName()
    {
        return 'payment';
    }

    public function rules()
    {
        return [
            [['user_id', 'sum', 'payment_destination_id', 'created_at'], 'required'],
            [['user_id', 'created_at', 'payment_destination_id'], 'integer'],
            [['sum'], 'number'],
            ['payment_destination_id', 'in', 'range' => array_keys($this::getPaymentDestinationIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'sum' => \Yii::t('app/attributes', 'Sum'),
            'payment_destination_id' => \Yii::t('app/attributes', 'Payment Destination'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function getPaymentDestinationIdList()
    {
        return [
            self::DESTINATION_ID_TRANSACTION  => \Yii::t('app/attributes', 'Payment Destination Transaction'),
            self::DESTINATION_ID_MONEY_BACK  => \Yii::t('app/attributes', 'Payment Destination Money Back'),
            self::DESTINATION_ID_PARTNER_FEE => \Yii::t('app/attributes', 'Payment Destination Partner Fee'),
        ];
    }

    public function getPaymentDestination()
    {
        return $this::getPaymentDestinationIdList()[$this->payment_destination_id];
    }


    public function getIsPartnerFee()
    {
        return $this->payment_destination_id == self::DESTINATION_ID_PARTNER_FEE;
    }

    public function getSumRUR()
    {
        return $this->sum;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
