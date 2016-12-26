<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\Dialog;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\message\DialogsManager;

class DialogMessagesController extends ApplicationController
{
    public function actionCreate($dialogId)
    {
        $user = $this->getUser();
        $dialog = $this->findDialogModel($dialogId);
        $postData = $this->getApp()->request->post();
        $message = $this->getDialogsManager($dialog)->sendMessage($postData);

        return $this->redirect([
            '/profile/dialogs/view',
            'id' => $dialog->id,
        ]);
    }

    protected function findDialogModel($id)
    {
        if (($model = Dialog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getDialogsManager($dialog)
    {
        return $this->createObject(
            DialogsManager::className(),
            [$this->getUser(), $dialog]
        );
    }
}
