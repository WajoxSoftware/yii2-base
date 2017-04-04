<?php
namespace wajox\yii2base\modules\admin\controllers;

class TrafficsController extends ApplicationController
{
    use \wajox\yii2base\modules\traffic\traits\TrafficControllerTrait;

    public function actionIndex()
    {
        return $this->viewManagersList();
    }

    public function actionViewUser($id)
    {
        return $this->viewUser($id);
    }

    public function actionViewSource($id, $stat = false)
    {
        return $this->viewSource($id, $stat);
    }

    public function actionViewStream($id)
    {
        return $this->viewStream($id);
    }
}
