<?php
namespace wajox\yii2base\models;

class EGoodEntity extends \wajox\yii2base\components\db\ActiveRecord
{
    const DEFAULT_FILE_PATH = '@noImagePath';

    const TYPE_ID_TEXT = 100;
    const TYPE_ID_VIDEO = 101;
    const TYPE_ID_AUDIO = 102;
    const TYPE_ID_ARCHIVE = 103;
    const TYPE_ID_IMAGE = 104;
    const TYPE_ID_LINK = 105;

    public static function tableName()
    {
        return 'egood_entity';
    }

    public function rules()
    {
        return [
            [['title'], 'filter', 'filter' => 'strip_tags'],
            [['title'], 'filter', 'filter' => 'htmlentities'],
            [['title'], 'filter', 'filter' => 'trim'],
            [['good_id', 'type_id', 'title'], 'required'],
            [['good_id', 'type_id', 'file_id'], 'integer'],
            [['content'], 'string'],
            [['file_url', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'type_id' => \Yii::t('app/attributes', 'Type ID'),
            'file_id' => \Yii::t('app/attributes', 'File ID'),
            'file_url' => \Yii::t('app/attributes', 'Url'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'description' => \Yii::t('app/attributes', 'Description'),
            'content' => \Yii::t('app/attributes', 'Content'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_TEXT => \Yii::t('app/attributes', 'EGood Entity Type ID Text'),
            self::TYPE_ID_VIDEO => \Yii::t('app/attributes', 'EGood Entity Type ID Video'),
            self::TYPE_ID_AUDIO => \Yii::t('app/attributes', 'EGood Entity Type ID Audio'),
            self::TYPE_ID_ARCHIVE => \Yii::t('app/attributes', 'EGood Entity Type ID Archive'),
            self::TYPE_ID_IMAGE => \Yii::t('app/attributes', 'EGood Entity Type ID Image'),
            self::TYPE_ID_LINK => \Yii::t('app/attributes', 'EGood Entity Type ID Link'),
        ];
    }

    public function getType()
    {
        return $this::getTypeIdList()[$this->type_id];
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    public function getUploadedFile()
    {
        return $this->hasOne(UploadedFile::className(), ['id' => 'file_id']);
    }

    public function getUploadedFileUrl()
    {
        $file = $this->uploadedFile ? $this->uploadedFile->fileUrl : \Yii::getAlias(self::DEFAULT_FILE_PATH);

        return $file;
    }

    public function getFileUrl()
    {
        if ($this->file_url == '') {
            return $this->getUploadedFileUrl();
        }

        return $this->file_url;
    }

    public function getIsText()
    {
        return $this->type_id == self::TYPE_ID_TEXT;
    }

    public function getIsVideo()
    {
        return $this->type_id == self::TYPE_ID_VIDEO;
    }

    public function getIsAudio()
    {
        return $this->type_id == self::TYPE_ID_AUDIO;
    }

    public function getIsArchive()
    {
        return $this->type_id == self::TYPE_ID_ARCHIVE;
    }

    public function getIsImage()
    {
        return $this->type_id == self::TYPE_ID_IMAGE;
    }
    public function getIsLink()
    {
        return $this->type_id == self::TYPE_ID_LINK;
    }
}
