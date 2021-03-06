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

    public function actionViewSource($id)
    {
        return $this->viewSource($id);
    }

    public function actionViewSourceStat($id)
    {
        return $this->viewSourceStat($id);
    }

    public function actionViewStream($id)
    {
        return $this->viewStream($id);
    }

    public function actionViewStreamPrices($id)
    {
        return $this->viewStreamPrices($id);
    }

    public function actionViewStreamStat($id)
    {
        return $this->viewStreamStat($id);
    }
}
