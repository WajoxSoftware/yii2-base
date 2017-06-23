<?php
namespace wajox\yii2base\modules\shop\models;

use wajox\yii2base\modules\payment\models\Order;

class GoodLetterEmail extends \wajox\yii2base\components\db\ActiveRecord
{
    const STATUS_ID_NEW = 100;
    const STATUS_ID_SEND = 200;
    const STATUS_ID_ERROR = 300;

    public static function tableName()
    {
        return 'good_letter_email';
    }

    public function rules()
    {
        return [
            [['good_email_id', 'order_id', 'status_id', 'scheduled_at'], 'required'],
            [['good_email_id', 'order_id', 'status_id', 'send_at', 'scheduled_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/general', 'ID'),
            'good_email_id' => \Yii::t('app/general', 'Good Email ID'),
            'order_id' => \Yii::t('app/general', 'Order ID'),
            'status_id' => \Yii::t('app/general', 'Status ID'),
            'send_at' => \Yii::t('app/general', 'Send At'),
            'scheduled_at' => \Yii::t('app/general', 'Scheduled At'),
        ];
    }

    public function getLetter()
    {
        return $this->hasOne(GoodLetter::className(), ['id' => 'good_email_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
