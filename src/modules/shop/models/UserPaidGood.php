<?php
namespace wajox\yii2base\modules\shop\models;

class UserPaidGood extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    public static function tableName()
    {
        return 'user_paid_good';
    }

    public function rules()
    {
        return [
            [['user_id', 'good_id', 'good_type_id', 'created_at'], 'required'],
            [['user_id', 'good_id', 'good_type_id', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/general', 'ID'),
            'user_id' => \Yii::t('app/general', 'User ID'),
            'good_id' => \Yii::t('app/general', 'Good ID'),
            'good_type_id' => \Yii::t('app/general', 'Good Type ID'),
            'created_at' => \Yii::t('app/general', 'Created At'),
        ];
    }

    public function isOwner($user_id)
    {
        return $this->user_id == $user_id;
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
