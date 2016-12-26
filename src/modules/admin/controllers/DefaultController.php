<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\form\StatisticFilterForm;
use wajox\yii2base\services\traffic\StatisticComputer;

class DefaultController extends ApplicationController
{
    public function actionIndex()
    {
        $model = $this->getFilterModel();
        $computer = $this->createObject(StatisticComputer::className());

        $cardsStat = $computer->fetch(
            $model->startDate,
            $model->finishDate
        );

        return $this->render('index', [
          'model' => $model,
          'cardsStat' => $cardsStat,
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
}
