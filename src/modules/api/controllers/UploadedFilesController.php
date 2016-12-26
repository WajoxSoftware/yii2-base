<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;

class UploadedFilesController extends ApplicationController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $request = $this->getApp()->request;

        $model = $this->getManager()->save($request);

        return $this->renderJson('create', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->getManager()->remove($id);

        return $this->renderJson('delete');
    }

    protected function getManager()
    {
        return $this->createObject(UoloadsManager::className(), [$this->getUser()]);
    }
}
