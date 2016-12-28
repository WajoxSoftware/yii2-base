<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\User;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\message\ContactsManager;

class ContactRequestsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $contactUser = $this->findUserModel($id);

        $result = $this->getContactsManager()->sendRequestTo($contactUser);

        return $this->renderJs('create', ['result' => $result]);
    }

    public function actionUpdate($id)
    {
        $contactUser = $this->findUserModel($id);

        $result = $this->getContactsManager()->approveRequest($contactUser);

        return $this->renderJs('update', ['result' => $result]);
    }

    public function actionDelete($id)
    {
        $contactUser = $this->findUserModel($id);

        $result = $this->getContactsManager()->cancelRequest($contactUser);

        return $this->renderJs('delete', ['result' => $result]);
    }

    protected function findUserModel($id)
    {
        return $this->findModelById(User::className(), $id);
    }

    protected function getContactsManager()
    {
        return $this->createObject(ContactsManager::className(), [$this->getUser()]);
    }
}
