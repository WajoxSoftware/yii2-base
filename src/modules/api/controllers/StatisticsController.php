<?php
namespace wajox\yii2base\modules\api\controllers;

use Yii;
use wajox\yii2base\services\traffic\StatisticManager;

class StatisticsController extends ApplicationController
{
    public function actionCreate()
    {
        $request = $this->getApp()->request;
        $errors = [];
        $success = false;

        if ($request->isPost) {
            $model = $this->getManager()->save($request);
            $success = $model->isNewRecord == false;
            $errors = $model->errors;
        }

        return $this->renderJson('create', [
            'model' => $model,
            'status' => $success,
            'errors' => $errors,
        ]);
    }

    protected function getManager()
    {
        return $this->getDependency(StatisticManager::className());
    }
}
