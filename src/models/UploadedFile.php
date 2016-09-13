<?php
namespace wajox\yii2base\models;

use wajox\yii2base\services\uploads\FileTypes;

class UploadedFile extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'uploaded_file';
    }

    public function rules()
    {
        return [
            [['file', 'size', 'user_id', 'type_id', 'status_id', 'created_at'], 'required'],
            [['size', 'user_id', 'type_id', 'status_id', 'created_at'], 'integer'],
            [['file'], 'file', 'extensions' => FileTypes::getAvailableExtensions()],
            [['size'], 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => $this->t('app/attributes', 'ID'),
            'file' => $this->t('app/attributes', 'File'),
            'size' => $this->t('app/attributes', 'Size'),
            'user_id' => $this->t('app/attributes', 'User ID'),
            'type_id' => $this->t('app/attributes', 'Type'),
            'status_id' => $this->t('app/attributes', 'Status'),
            'created_at' => $this->t('app/attributes', 'Created At'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => '\yiidreamteam\upload\FileUploadBehavior',
                'attribute' => 'file',
                'filePath' => '@webroot/uploads/uploaded_files/[[pk]].[[extension]]',
                'fileUrl' => '@web/uploads/uploaded_files/[[pk]].[[extension]]',
            ],
        ];
    }

    public function getFileUrl()
    {
        return $this->getUploadedFileUrl('file');
    }

    public function getFilePath()
    {
        return $this->getUploadedFilePath('file');
    }

    public function getIsImage()
    {
        return $this->type_id == FileTypes::TYPE_ID_IMAGE;
    }

    public function getIsVideo()
    {
        return $this->type_id == FileTypes::TYPE_ID_VIDEO;
    }

    public function getIsAudio()
    {
        return $this->type_id == FileTypes::TYPE_ID_AUDIO;
    }

    public function getIsText()
    {
        return $this->type_id == FileTypes::TYPE_ID_Text;
    }

    public function getIsDocument()
    {
        return $this->type_id == FileTypes::TYPE_ID_DOCUMENT;
    }

    public function getIsArchive()
    {
        return $this->type_id == FileTypes::TYPE_ID_ARCHIVE;
    }

    public function getIsBinary()
    {
        return $this->type_id == FileTypes::TYPE_ID_BINARY;
    }

    public function getIsUnknown()
    {
        return $this->type_id == FileTypes::TYPE_ID_UNKNOWN;
    }
}
