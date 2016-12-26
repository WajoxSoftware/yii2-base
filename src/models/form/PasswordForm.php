<?php

namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\models\User;

class PasswordForm extends Model
{
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 4],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function process()
    {
        if ($this->validate()) {
            $user = User::find()->byIdentity($this->getApp()->user->id)->one();
            $user->scenario = 'change_password';
            $user->setPassword($this->password);
            $user->generateAuthKey();

            return $user->save();
        }

        return false;
    }

    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app/attributes', 'Password'),
            'password_repeat' => \Yii::t('app/attributes', 'Repeat Password'),
        ];
    }
}
