<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;

class ConfirmationForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'strip_tags'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'required'],
        ];
    }

    public function process()
    {
        $model = $this->getManager()->findByEmail($this->email);
        if ($model == null) {
            return false;
        }

        return $this->getManager()->sendConfirmationEmail($model);
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app/attributes', 'Email'),
        ];
    }

    public function getManager()
    {
        return $this->getApp()->usersManager;
    }
}
