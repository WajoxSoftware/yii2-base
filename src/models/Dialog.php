<?php
namespace wajox\yii2base\models;

class Dialog extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'dialog';
    }

    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
        ];
    }

    public function getDialogUsers()
    {
        return $this->hasMany(DialogUser::className(), ['dialog_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable(DialogUser::tableName(), ['dialog_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['dialog_id' => 'id']);
    }

    public function getLastMessage()
    {
        return $this->hasOne(Message::className(), ['dialog_id' => 'id'])->orderBy('[[status_at]] DESC');
    }

    public function getDialogMembersKey()
    {
        return $this->hasOne(DialogMembers::className(), ['id' => 'id']);
    }

    public function getJson()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }
}
