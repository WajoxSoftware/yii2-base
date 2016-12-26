<?php
namespace wajox\yii2base\models;

class ContentNodeFIle extends \wajox\yii2base\components\db\ActiveRecord
{
    const DEFAULT_FILE_PATH = '@noImagePath';

    public static function tableName()
    {
        return 'content_node_file';
    }

    public function rules()
    {
        return [
            [['content_node_id', 'uploaded_file_id'], 'required'],
            [['content_node_id', 'uploaded_file_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'content_node_id' => \Yii::t('app/attributes', 'ID'),
            'uploaded_ifile_id' => \Yii::t('app/attributes', 'ID'),
        ];
    }

    public function getUrl()
    {
        $file = $this->uploadedFile ? $this->uploadedFile->fileUrl : \Yii::getAlias(self::DEFAULT_FILE_PATH);

        return $file;
    }

    public function getUploadedFile()
    {
        return $this->hasOne(UploadedFile::className(), ['id' => 'uploaded_file_id']);
    }
}
