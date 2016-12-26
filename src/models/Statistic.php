<?php
namespace wajox\yii2base\models;

class Statistic extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    public static function tableName()
    {
        return 'statistic';
    }

    public function rules()
    {
        return [
            [['guid', 'page_url', 'page_title', 'ref_page_url', 'browser_data', 'screen_size'], 'filter', 'filter' => 'strip_tags'],
            [['guid', 'page_url', 'page_title', 'ref_page_url', 'browser_data', 'screen_size'], 'filter', 'filter' => 'htmlentities'],
            [['guid', 'page_url', 'page_title', 'ref_page_url', 'browser_data', 'screen_size'], 'filter', 'filter' => 'trim'],
            [['user_id', 'scroll', 'spend_time', 'created_at'], 'integer'],
            [['created_at'], 'required'],
            [['guid', 'page_url', 'page_title', 'ref_page_url', 'browser_data', 'screen_size'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'page_url' => \Yii::t('app/attributes', 'Page Url'),
            'page_title' => \Yii::t('app/attributes', 'Page Title'),
            'ref_page_url' => \Yii::t('app/attributes', 'Ref Page Url'),
            'browser_data' => \Yii::t('app/attributes', 'Browser Data'),
            'scroll' => \Yii::t('app/attributes', 'Scroll'),
            'screen_size' => \Yii::t('app/attributes', 'Screen Size'),
            'spend_time' => \Yii::t('app/attributes', 'Spend Time'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserName()
    {
        if ($this->user == null) {
            return 'None';
        }

        return $this->user->nameWithEmail;
    }
}
