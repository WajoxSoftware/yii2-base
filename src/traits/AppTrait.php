<?php
namespace wajox\yii2base\traits;

trait AppTrait
{
    public static function getApp()
    {
        return \Yii::$app;
    }

    public static function getAppRequest()
    {
        return \Yii::$app->request;
    }

    public static function getAppUser()
    {
        return \Yii::$app->user;
    }

    public static function getService($id, $throwException = true)
    {
        return \Yii::$app->get($id, $throwException);
    }
}
