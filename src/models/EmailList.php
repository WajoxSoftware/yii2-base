<?php
namespace wajox\yii2base\models;

use wajox\yii2base\models\query\EmailListQuery;

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
            [['title', 'api_id', 'url'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'api_id', 'url'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'url', 'api_id'], 'filter', 'filter' => 'trim'],
            [['url', 'api_id', 'title', 'redirect_url'], 'required'],
            [['title', 'api_id', 'redirect_url', 'url'], 'string', 'max' => 255],
            ['url', 'unique'],
            ['redirect_url', 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'api_id' => \Yii::t('app/attributes', 'Api ID'),
            'redirect_url' => \Yii::t('app/attributes', 'Redirect URL'),
        ];
    }

    public static function find()
    {
        return self::createObject(
            EmailListQuery::className(),
            [get_called_class()]
        );
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
