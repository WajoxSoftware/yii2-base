<?php
namespace wajox\yii2base\modules\shop\controllers;

class DefaultController extends ApplicationController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
