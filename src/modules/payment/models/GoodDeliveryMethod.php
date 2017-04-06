<?php
namespace wajox\yii2base\modules\payment\models;

class GoodDeliveryMethod extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_delivery_method';
    }

    public function behaviors()
    {
        return [
            'serializedAttributes' => [
                'class' => "\baibaratsky\yii\behaviors\model\SerializedAttributes",
                'attributes' => ['extra'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['good_id', 'delivery_method'], 'required'],
            [['good_id'], 'integer'],
            [['delivery_method'], 'filter', 'filter' => 'strip_tags'],
            [['delivery_method'], 'filter', 'filter' => 'trim'],
            [['delivery_method'], 'string', 'max' => 255],
            [['delivery_price'], 'double', 'min' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'delivery_method' => \Yii::t('app/attributes', 'Delivery Method'),
            'delivery_price' => \Yii::t('app/attributes', 'Delivery Price'),
            'extra' => \Yii::t('app/attributes', 'Extra'),
        ];
    }

    public function getDeliverySumRUR()
    {
        return $this->delivery_price;
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
