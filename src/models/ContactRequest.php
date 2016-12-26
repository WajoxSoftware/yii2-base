<?php
namespace wajox\yii2base\models;

class ContactRequest extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'contact_request';
    }

    public function rules()
    {
        return [
            [['user_id', 'contact_user_id'], 'required'],
            [['user_id', 'contact_user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'contact_user_id' => \Yii::t('app/attributes', 'Contact User ID'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getContactUser()
    {
        return $this->hasOne(User::className(), ['id' => 'contact_user_id']);
    }
}
