<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\rbac\TrafficStreamAuthorRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        //$dashboard = $auth->createPermission('dashboard');
        //$dashboard->description = 'Админ панель';
        //$auth->add($dashboard);
        //Включаем наш обработчик

        //Добавляем роли
        $user = $auth->createRole('user');
        $auth->add($user);
        //
        $partner = $auth->createRole('partner');
        $auth->add($partner);
        $auth->addChild($partner, $user);

        $employee = $auth->createRole('employee');
        $auth->add($employee);
        $auth->addChild($employee, $user);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $employee);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
    }
}
