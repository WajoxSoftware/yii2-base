<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\modules\partner\models\StatisticFilterForm;
use wajox\yii2base\services\traffic\StatisticComputer;

class DefaultController extends ApplicationController
{
    public function actionIndex()
    {
        $model = $this->getFilterModel();
        $stat = $this->getStat($model, $model->getExtParams());

        return $this->render('index', [
          'model' => $model,
          'stat' => $stat,
        ]);
    }

    protected function getFilterModel()
    {
        $request = $this->getApp()->request;
        $model = $this->createObject(StatisticFilterForm::className());
        $model->load($request->post());
        $model->validate();
        $model->compute();

        return $model;
    }

    protected function getStat($model)
    {
        $computer = $this->createObject(StatisticComputer::className(), [$this->getUser()]);

        $stat = [];

        foreach ($model->getComputedIntervalSteps() as $stepDates) {
            $items = $computer->fetch(
                $stepDates['startAt'],
                $stepDates['finishAt']
            );
            $stat[] = ['dates' => $stepDates, 'items' => $items];
        }

        return $stat;
    }
}
