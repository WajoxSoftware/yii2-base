<?php
namespace wajox\yii2base\models;

class EautopayOrder extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'eautopay_order';
    }

    public function rules()
    {
        return [
            [['order_id', 'eautopay_order_id', 'status', 'status_at'], 'required'],
            [['order_id', 'eautopay_order_id', 'status_at'], 'integer'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'order_id' => \Yii::t('app/attributes', 'Order ID'),
            'eautopay_order_id' => \Yii::t('app/attributes', 'Eautopay Order ID'),
            'status' => \Yii::t('app/attributes', 'Status'),
            'status_at' => \Yii::t('app/attributes', 'Status At'),
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
