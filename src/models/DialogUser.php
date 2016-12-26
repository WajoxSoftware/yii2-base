<?php
namespace wajox\yii2base\models;

class DialogUser extends \wajox\yii2base\components\db\ActiveRecord
{
    const STATUS_ID_ACTIVE = 100;
    const STATUS_ID_INACTIVE = 200;

    public static function tableName()
    {
        return 'dialog_user';
    }

    public function rules()
    {
        return [
            [['dialog_id', 'user_id', 'message_id', 'created_at', 'updated_at', 'status_id'], 'required'],
            [['dialog_id', 'user_id', 'message_id', 'created_at', 'updated_at', 'status_id'], 'integer'],
            [['status_id'], 'in', 'range' => array_keys($this::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'dialog_id' => \Yii::t('app/attributes', 'Dialog ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'message_id' => \Yii::t('app/attributes', 'Message ID'),
            'updated_at' => \Yii::t('app/attributes', 'Updated At'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
        ];
    }

    public function getDialog()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'dialog_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'User Notification Status ID New'),
            self::STATUS_ID_READ => \Yii::t('app/attributes', 'User Notification Status ID Read'),
        ];
    }

    public function getIsActive()
    {
        return $this->status_id == self::STATUS_ID_ACTIVE;
    }
}
