<?php
namespace wajox\yii2base\modules\webinar\controllers;

use wajox\yii2base\modules\webinar\models\WebinarMessage;
use yii\web\NotFoundHttpException;

class WebinarMessageController extends ApplicationController
{
    public function actionCreate(int $id)
    {
        $success = false;
        $request = $this->getApp()->request;
        $manager = $this->getManager();
        $webinar = $manager->findModel($id);
        $viewer = $manager->getCurrentViewer($webinar);
        $model = new WebinarMessage();

        if ($request->isPost
            && $model->load($request->post())
        ) {
            $model->user_id = $this->getApp()->visitor->userId;
            $model->guid = $this->getApp()->visitor->guid;
            $model->name = $viewer->name;
            $model->email = $viewer->email;
            $model->webinar_id = $webinar->id;
            $model->created_at = time();
            $success = $model->save();
        }

        if ($success) {
            $this->getMailer()->sendQuestion();
        }

        return $this->renderJs('create', [
            'success' => $success,
            'model' => $model,
        ]);
    }

    protected function getManager()
    {
        return $this->createObject(
            \wajox\yii2base\modules\webinar\services\WebinarManager::className()
        );
    }

    protected function getMailer($message)
    {
        return $this->createObject(
            \wajox\yii2base\modules\webinar\services\WebinarMessageMailer::className(),
            [$message]
        );
    }
}
