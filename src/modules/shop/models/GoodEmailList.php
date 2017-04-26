<?php
namespace wajox\yii2base\modules\shop\models;

use wajox\yii2base\models\EmailList;

class GoodEmailList extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'good_email_list';
    }

    public function rules()
    {
        return [
            [['good_id', 'email_list_id'], 'required'],
            [['good_id', 'email_list_id'], 'integer'],
            ['email_list_id', 'unique', 'targetAttribute' => ['good_id', 'email_list_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'good_id' => \Yii::t('app/attributes', 'Good ID'),
            'email_list_id' => \Yii::t('app/attributes', 'Email List ID'),
        ];
    }

    public function getEmailList()
    {
        return $this->hasOne(EmailList::className(), ['id' => 'email_list_id']);
    }
}
