<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\modules\account\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\message\ContactsManager;

class UserContactsController extends ApplicationController
{
    public function actionIndex()
    {
        $user = $this->getUser();

        $query = $this->getContactsManager()->getContactsQuery();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
                ['query' => $query],
            ]);

        return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionRequests()
    {
        $user = $this->getUser();
        $query = $this->getContactsManager()->getRequestsQuery();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
                ['query' => $query],
            ]);

        return $this->render('requests', [
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionFind()
    {
        $request = $this->getApp()->request;
        $user = $this->getUser();

        $exceptUserIds = [$user->id];
        foreach ($user->getContacts()->each() as $user) {
            $exceptUserIds[] = $user->contact_user_id;
        }

        $searchModel = $this->createObject(UserSearch::className());
        $dataProvider = $searchModel->search($request->queryParams, $exceptUserIds);
        $sentRequests = $this->getContactsManager()->getSentRequests();

        return $this->render('find', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sentRequests' => $sentRequests,
        ]);
    }

    public function actionDelete($id)
    {
        $user = $this->getUser();
        $contactUser = $this->findUserModel($id);
        $result = $this->getContactsManager()->removeContact($contactUser);

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
