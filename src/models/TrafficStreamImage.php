<?php
namespace wajox\yii2base\models;

class TrafficStreamImage extends \wajox\yii2base\components\db\ActiveRecord
{
    const DEFAULT_PREVIEW_PATH = '@noImagePath';
    const DEFAULT_FILE_PATH = '@noImagePath';

    public static function tableName()
    {
        return 'traffic_stream_image';
    }

    public function rules()
    {
        return [
            [['traffic_stream_id', 'uploaded_image_id'], 'required'],
            [['traffic_stream_id', 'uploaded_image_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'traffic_stream_id' => \Yii::t('app', 'Traffic Stream ID'),
            'uploaded_image_id' => \Yii::t('app', 'Uploaded Image ID'),
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

    public function getStream()
    {
        return $this->hasOne(TrafficStream::className(), ['id' => 'traffic_source_id']);
    }
}
