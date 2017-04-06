<?php
namespace wajox\yii2base\models;

class TrafficSource extends \wajox\yii2base\components\db\ActiveRecord
{
    const TYPE_ID_LINK = 100;
    const TYPE_ID_GOOD = 200;

    const STATUS_ID_ACTIVE = 100;
    const STATUS_ID_INACTIVE = 101;

    protected $_streamsCount = null;
    
    public $targetUrl;
    public $targetGoodId;

    public static function tableName()
    {
        return 'traffic_source';
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'tag', 'status_id', 'type_id', 'target'], 'required'],
            [['user_id', 'status_id', 'type_id'], 'integer'],
            [['title', 'tag'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'tag'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'tag'], 'filter', 'filter' => 'trim'],
            [['title', 'tag'], 'string', 'max' => 255],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
            [['targetUrl'], 'url'],
            [['targetGoodId'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'status_id' => \Yii::t('app/attributes', 'Status'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_INACTIVE => \Yii::t('app/attributes', 'Good Status Inactive'),
            self::STATUS_ID_ACTIVE => \Yii::t('app/attributes', 'Good Status Active'),
        ];
    }

    public function getStatus()
    {
        return $this::getStatusIdList()[$this->status_id];
    }

    public function getIsActive()
    {
        return $this->status_id == self::STATUS_ID_ACTIVE;
    }


    public function getStreams()
    {
        return $this->hasMany(TrafficStream::className(), ['traffic_source_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getHasParentSource()
    {
        return $this->parentSource != null;
    }

    public function getHasStreams()
    {
        if ($this->_streamsCount == null) {
            $this->_streamsCount = $this->getStreams()->count();
        }

        return  $this->_streamsCount > 0;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $success = parent::save($runValidation, $attributeNames);

        if (!$success) {
            return false;
        }

        if (!$this->isActive) {
            foreach ($this->streams as $stream) {
                $stream->status = self::STATUS_ID_INACTIVE;
                $stream->save();
            }
        }

        return true;
    }

    public function getIsLink()
    {
        return $this->type_id == self::TYPE_ID_LINK;
    }

    public function getIsGood()
    {
        return $this->type_id == self::TYPE_ID_GOOD;
    }

    public function getTargetUrl()
    {
        if ($this->isLink) {
            return $this->target;
        }
    }

    public function beforeValidate()
    {
        if ($this->isLink) {
            $this->target = $this->targetUrl;
        }

        return parent::beforeValidate();
    }
}
