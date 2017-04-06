<?php
namespace wajox\yii2base\modules\payment\models;

class OrderStatus extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    public static function tableName()
    {
        return 'order_status';
    }

    public function rules()
    {
        return [
            [['order_id', 'status_id', 'delivery_status_id'], 'required'],
            [['order_id', 'created_at', 'status_id', 'delivery_status_id', 'uploaded_file_id'], 'integer'],
            [['comment'], 'filter', 'filter' => 'strip_tags'],
            [['comment'], 'filter', 'filter' => 'htmlentities'],
            [['comment'], 'filter', 'filter' => 'trim'],
            [['comment'], 'string', 'max' => 3000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'order_id' => \Yii::t('app/attributes', 'Order ID'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'delivery_status_id' => \Yii::t('app/attributes', 'Delivery Status'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'comment' => \Yii::t('app/attributes', 'Comment'),
        ];
    }

    public function getStatus()
    {
        return Order::getStatusIdList()[$this->status_id];
    }

    public function getDeliveryStatus()
    {
        return Order::getDeliveryStatusIdList()[$this->delivery_status_id];
    }

    public function getFileUrl()
    {
        $file = $this->uploadedFile ? $this->uploadedFile->fileUrl : null;

        return $file;
    }

    public function getFileName()
    {
        $file = $this->uploadedFile ? $this->uploadedFile->file : null;

        return $file;
    }

    public function getUploadedFile()
    {
        return $this->hasOne(UploadedFile::className(), ['id' => 'uploaded_file_id']);
    }
}
