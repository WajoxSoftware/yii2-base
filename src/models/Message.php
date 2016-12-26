<?php
namespace wajox\yii2base\models;

class Message extends \wajox\yii2base\components\db\ActiveRecord
{
    const STATUS_ID_SENDING = 100;
    const STATUS_ID_SEND = 101;

    public $_status_at = null;

    public static function tableName()
    {
        return 'message';
    }

    public function rules()
    {
        return [
            [['content'], 'filter', 'filter' => 'strip_tags'],
            [['content'], 'filter', 'filter' => 'htmlentities'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['user_id', 'status_at', 'status_id'], 'integer'],
            [['content', 'status_at', 'user_id', 'dialog_id', 'status_id'], 'required'],
            [['content'], 'string'],
            [['status_id'], 'in', 'range' => array_keys($this::getStatusIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'dialog_id' => \Yii::t('app/attributes', 'Message Receiver'),
            'user_id' => \Yii::t('app/attributes', 'Message Sender'),
            'content' => \Yii::t('app/attributes', 'Content'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
            'status_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDialog()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'dialog_id']);
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_SENDING => \Yii::t('app/attributes', 'Message Status Sending'),
            self::STATUS_ID_SEND => \Yii::t('app/attributes', 'Message Status Send'),
        ];
    }

    public function getStatusDate()
    {
        if ($this->_status_at == null) {
            $this->_status_at = date('d.m.Y H:i', $this->status_at);
        }

        return $this->_status_at;
    }

    public function short_content()
    {
        return mb_substr($this->content, 0, 140, 'utf-8');
    }

    public function getJson()
    {
        return [
            'id' => $this->id,
            'dialog_id' => $this->dialog_id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'status_at' => $this->status_at,
            'content' => $this->content,
        ];
    }
}
