<?php

namespace wajox\yii2base\helpers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\TrafficManager;
use yii\helpers\ArrayHelper;

class UsersHelper
{
    public static function getGenderList()
    {
        return User::getGenderList();
    }
    
    public static function getUsersList($user_id = 0)
    {
        $users = User::find()->where('id != :id', ['id' => $user_id])->all();

        return ArrayHelper::map($users, 'id', 'name');
    }

    public static function getManagersList($user_id = 0)
    {
        $users = User::find()
            ->where('id != :id', ['id' => $user_id])
            ->andWhere(['role' => 'manager'])->all();

        return ArrayHelper::map($users, 'id', 'name');
    }

    public static function getTrafficManagersList($user_id = 0)
    {
        $users = TrafficManager::find()->all();

        return ArrayHelper::map($users, 'user_id', 'name');
    }

    public static function getUserByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }

    public static function getUserIdByEmail($email, $default = 0)
    {
        $user = self::getUserByEmail($email);

        if ($user == null) {
            return $default;
        }

        return $user->id;
    }
}
