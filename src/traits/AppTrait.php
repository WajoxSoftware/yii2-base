<?php
namespace wajox\yii2base\traits;

use wajox\yii2base\components\db\Repository;
use yii\base\Application;
use yii\web\User;
use yii\db\Connection as DbConnection;

trait AppTrait
{
    public static function getApp(): Application
    {
        return \Yii::$app;
    }

    public static function getAppRequest()
    {
        return \Yii::$app->request;
    }

    public static function getAppUser(): User
    {
        return \Yii::$app->user;
    }

    public static function getService(string $id, bool $throwException = true)
    {
        return \Yii::$app->get($id, $throwException);
    }

    public static function getRepository(): Repository
    {
        return \Yii::$app->repository;
    }

    public static function getDb(): DbConnection
    {
        return \Yii::$app->db;
    }
}
