<?php
namespace wajox\yii2base\models;

use wajox\yii2base\services\uploads\FileTypes;

class UploadedImage extends UploadedFile
{

    public function rules()
    {
        return [
            [['file', 'size', 'user_id', 'type_id', 'status_id', 'created_at'], 'required'],
            [['size', 'user_id', 'type_id', 'status_id', 'created_at'], 'integer'],
            [['file'], 'file', 'extensions' => FileTypes::getImageExtensions()],
        ];
    }

    public function behaviors()
    {
        return [
            [
                 'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                 'attribute' => 'file',
                 'thumbs' => ['thumb' => ['width' => 100, 'height' => 100]],
                 'filePath' => '@uploadsPath/uploaded_files/[[pk]].[[extension]]',
                 'fileUrl' => '@uploadsUrl/uploaded_files/[[pk]].[[extension]]',
                 'thumbPath' => '@uploadsPath/uploaded_files/thumbnail_[[pk]].[[extension]]',
                 'thumbUrl' => '@uploadsUrl/uploaded_files/thumbnail_[[pk]].[[extension]]',
            ],
        ];
    }

    public function getPreviewUrl()
    {
        if ($this->isImage) {
            return $this->getThumbFileUrl('file', 'thumb');
        }

        return;
    }

    public function getPreviewPath()
    {
        if ($this->isImage) {
            return $this->getThumbFilePath('file', 'thumb');
        }

        return;
    }
}
