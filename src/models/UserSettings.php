<?php
namespace wajox\yii2base\models;

class UserSettings extends \wajox\yii2base\components\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user_settings';
    }

    public function rules()
    {
        return [
            [['view_profile', 'search_profile', 'add_profile', 'message_profile', 'show_contacts', 'send_notifications'], 'required'],
            [['view_profile', 'search_profile', 'add_profile', 'message_profile', 'show_contacts', 'send_notifications'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/general', 'ID'),
            'view_profile' => \Yii::t('app/attributes', 'User Profile Access View Profile'),
            'search_profile' => \Yii::t('app/attributes', 'User Profile Access Search Profile'),
            'add_profile' => \Yii::t('app/attributes', 'User Profile Access Add Profile'),
            'show_contacts' => \Yii::t('app/attributes', 'User Profile Access Show Contacts'),
            'message_profile' => \Yii::t('app/attributes', 'User Profile Access Message Profile'),
            'send_notifications' => \Yii::t('app/attributes', 'User Profile Settings Send Notifications'),
        ];
    }

    public function getNotificationsEnabled()
    {
        return $this->send_notifications == 1;
    }
}
