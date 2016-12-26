<?php
namespace wajox\yii2base\models;

class OrderGood extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'order_good';
    }

    public function rules()
    {
        return [
            [['order_id', 'good_id', 'items_count'], 'required'],
            [['order_id', 'good_id', 'items_count'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'order_id' => \Yii::t('app/attributes', 'Order ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'items_count' => \Yii::t('app/attributes', 'Count'),
        ];
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
