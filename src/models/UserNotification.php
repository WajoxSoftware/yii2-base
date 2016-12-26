<?php
namespace wajox\yii2base\models;

class UserNotification extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const MAX_SHORT_MESSAGE_LENGTH = 77;

    const TYPE_ID_SYSTEM = 100;
    const TYPE_ID_ACCOUNT = 200;
    const TYPE_ID_ORDER = 300;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_READ = 200;

    const CONTENT_SUBJECT = 'subject';
    const CONTENT_MESSAGE = 'message';

    public static function tableName()
    {
        return 'user_notification';
    }

    public function behaviors()
    {
        return [
            'serializedAttributes' => [
                'class' => "\baibaratsky\yii\behaviors\model\SerializedAttributes",
                'attributes' => ['content'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'content', 'type_id', 'status_id', 'created_at'], 'required'],
            [['user_id', 'created_at', 'type_id', 'status_id'], 'integer'],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
            ['type_id', 'in', 'range' => array_keys($this::getTypeIdList())],
            [['content'], 'filter', 'filter' => 'strip_tags'],
            [['content'], 'filter', 'filter' => 'htmlentities'],
            [['content'], 'filter', 'filter' => 'trim'],
            [['content'], 'string', 'max' => 5000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'content' => \Yii::t('app', 'Content'),
            'status_id' => \Yii::t('app', 'Status'),
            'created_at' => \Yii::t('app', 'Created At'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'User Notification Status ID New'),
            self::STATUS_ID_READ => \Yii::t('app/attributes', 'User Notification Status ID Read'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_SYSTEM => \Yii::t('app/attributes', 'User Notification Type System'),
            self::TYPE_ID_ACCOUNT => \Yii::t('app/attributes', 'User Notification Type Account'),
            self::TYPE_ID_ORDER => \Yii::t('app/attributes', 'User Notification Type Order'),
        ];
    }

    public function getStatus()
    {
        return self::getStatusIdList()[$this->status_id];
    }

    public function getType()
    {
        return $this->getTypeIdList()[$this->type_id];
    }

    public function getSubject()
    {
        return $this->getContentParam(self::CONTENT_SUBJECT);
    }

    public function getMessage()
    {
        return $this->getContentParam(self::CONTENT_MESSAGE);
    }

    public function getShortMessage()
    {
        $message = $this->getMessage();

        if (mb_strlen($message) > self::MAX_SHORT_MESSAGE_LENGTH) {
            return mb_substr($message, 0, self::MAX_SHORT_MESSAGE_LENGTH) . '...';
        }

        return $message;
    }
    public function setSubject($subject)
    {
        return $this->setContentParam(self::CONTENT_SUBJECT, $subject);
    }

    public function setMessage($message)
    {
        return $this->setContentParam(self::CONTENT_MESSAGE, $message);
    }

    public function setContentParam($name, $value)
    {
        $content = $this->content;

        $content[$name] = $value;

        $this->content = $content;

        return $this;
    }

    public function getContentParam($name)
    {
        if (isset($this->content[$name])) {
            return $this->content[$name];
        }

        return;
    }

    public function setContentParams($params)
    {
        foreach ($params as $name => $value) {
            $this->setContentParam($name, $value);
        }

        return $this;
    }

    public function getIsUnread()
    {
        return $this->status_id == self::STATUS_ID_NEW;
    }
}
