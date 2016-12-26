<?php
namespace wajox\yii2base\models;

class GoodImage extends \wajox\yii2base\components\db\ActiveRecord
{
    const DEFAULT_PREVIEW_PATH = '@noImagePath';
    const DEFAULT_FILE_PATH = '@noImagePath';

    public static function tableName()
    {
        return 'good_image';
    }

    public function rules()
    {
        return [
            [['good_id', 'uploaded_image_id'], 'required'],
            [['good_id', 'uploaded_image_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'ID'),
            'uploaded_image_id' => \Yii::t('app/attributes', 'ID'),
        ];
    }

    public function getPreviewUrl()
    {
        $file = $this->uploadedImage ? $this->uploadedImage->previewUrl : \Yii::getAlias(self::DEFAULT_PREVIEW_PATH);

        return $file;
    }

    public function getUrl()
    {
        $file = $this->uploadedImage ? $this->uploadedImage->fileUrl : \Yii::getAlias(self::DEFAULT_FILE_PATH);

        return $file;
    }

    public function getUploadedImage()
    {
        return $this->hasOne(UploadedImage::className(), ['id' => 'uploaded_image_id']);
    }
}
