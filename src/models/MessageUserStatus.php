<?php
namespace wajox\yii2base\models;

class MessageUserStatus extends \wajox\yii2base\components\db\ActiveRecord
{
    const STATUS_ID_NEW = 100;
    const STATUS_ID_READ = 101;
    const STATUS_ID_DELETED = 102;

    public static function tableName()
    {
        return 'message_user_status';
    }

    public function rules()
    {
        return [
            [['message_id', 'dialog_id', 'user_id', 'status_id', 'status_at'], 'required'],
            [['message_id', 'dialog_id', 'user_id', 'status_id', 'status_at', 'created_at'], 'integer'],
            [['status_id'], 'in', 'range' => array_keys($this::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'message_id' => \Yii::t('app/attributes', 'Message ID'),
            'dialog_id' => \Yii::t('app/attributes', 'Dialog ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'status_at' => \Yii::t('app/attributes', 'Status At'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Message Status New'),
            self::STATUS_ID_READ => \Yii::t('app/attributes', 'Message Status Read'),
            self::STATUS_ID_DELETED => \Yii::t('app/attributes', 'Message Status Deleted'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }
}
