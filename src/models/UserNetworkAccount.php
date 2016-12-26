<?php
namespace wajox\yii2base\models;

class UserNetworkAccount extends \wajox\yii2base\components\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_network_account';
    }

    public function rules()
    {
        return [
            [['user_id', 'provider', 'uid', 'params', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['provider', 'uid'], 'filter', 'filter' => 'strip_tags'],
            [['provider', 'uid'], 'filter', 'filter' => 'htmlentities'],
            [['provider', 'uid'], 'filter', 'filter' => 'trim'],
            [['provider', 'uid'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'serializedAttributes' => [
                'class' => "\baibaratsky\yii\behaviors\model\SerializedAttributes",
                'attributes' => ['params'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'provider' => 'Provider',
            'uid' => 'Uid',
            'params' => 'Params',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
