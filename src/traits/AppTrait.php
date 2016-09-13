<?php
namespace wajox\yii2base\traits;

trait AppTrait
{
    public function getApp()
    {
        return \Yii::$app;
    }

    public function getService($id, $throwException = true )
    {
    	return \Yii::$app->get($id, $throwException);
    }
}
