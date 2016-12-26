<?php
namespace wajox\yii2base\models;

class GoodPaymentMethod extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_payment_method';
    }

    public function rules()
    {
        return [
            [['good_id', 'payment_method'], 'required'],
            [['good_id'], 'integer'],
            [['payment_method'], 'filter', 'filter' => 'strip_tags'],
            [['payment_method'], 'filter', 'filter' => 'htmlentities'],
            [['payment_method'], 'filter', 'filter' => 'trim'],
            [['payment_method'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'payment_method' => \Yii::t('app/attributes', 'Payment Method'),
        ];
    }
}
