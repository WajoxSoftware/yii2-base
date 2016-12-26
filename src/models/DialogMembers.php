<?php
namespace wajox\yii2base\models;

class DialogMembers extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dialog_members';
    }

    public function rules()
    {
        return [
            [['users_ids'], 'required'],
            [['users_ids'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'users_ids' => \Yii::t('app', 'Users Ids'),
        ];
    }
}
