<?php
namespace wajox\yii2base\models;

class EmailList extends \wajox\yii2base\components\db\ActiveRecord
{
    const VIEW_ROUTE = '/subscribes/view';

    public static function tableName()
    {
        return 'email_list';
    }

    public function rules()
    {
        return [
            [['title', 'description', 'api_id', 'url'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'description', 'api_id', 'url'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'description', 'url', 'api_id'], 'filter', 'filter' => 'trim'],
            [['url', 'api_id', 'title', 'description'], 'required'],
            [['title', 'api_id', 'description', 'url'], 'string', 'max' => 255],
            ['url', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'api_id' => \Yii::t('app/attributes', 'Api ID'),
            'description' => \Yii::t('app/attributes', 'Description'),
        ];
    }

    public function getSubscribes()
    {
        return $this->hasMany(Subscribe::className(), ['email_list_id' => 'id']);
    }

    public function getSubscribeUrl()
    {
        return \yii\helpers\Url::toRoute([self::VIEW_ROUTE, 'url' => $this->url]);
    }
}
