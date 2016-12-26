<?php

namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\modules\admin\models\SettingsForm;

class SettingsController extends ApplicationController
{
    public function actionIndex()
    {
        $model = $this->createObject(SettingsForm::className());
        $model->loadSettings();
        $request = $this->getApp()->request;

        if ($request->isPost) {
            $model->load($request->post());
            $model->updateSettings();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
