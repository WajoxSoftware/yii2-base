<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\models\User;
use wajox\yii2base\services\users\UsersManager;


class UsersController extends Controller
{
    public function actionCreate()
    {
        $manager = new UsersManager();
        $model = new User(['scenario' => 'signup']);
        $model->first_name = 'Jhon';
        $model->last_name = 'Doe';
        $model->email = 'admin@example.com';
        $model->confirmed_email = 'admin@example.com';
        $model->confirmed_at = time();
        $model->name = 'admin';
        $model->password = 'password123';
        $model->role = 'admin';
        $model->guid = md5(uniqid(time(), true));
        $model->created_at = time();

        $model = $manager->save($model, false, false);

        if ($model && !$model->isNewRecord) {
            return true;
        }

        print_r($model->errors);
    }
}
