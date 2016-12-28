<?php
namespace wajox\yii2base\modules\account\controllers;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\UserNotification;
use wajox\yii2base\services\notifications\UserNotificationsManager;

class NotificationsController extends ApplicationController
{
    public function actionIndex()
    {
        $query = $this
            ->getRepository()
            ->find(UserNotification::className())
            ->where(['user_id' => $this->getUser()->id])
            ->orderBy('created_at DESC');

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->isUnread) {
            $this->getManager()->read($id);
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(UserNotification::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getManager()
    {
        return $this->createObject(
            UserNotificationsManager::className(),
            [$this->getUser()]
        );
    }
}
