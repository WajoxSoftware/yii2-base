<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\Dialog;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use wajox\yii2base\services\message\DialogsManager;
use wajox\yii2base\services\message\MessagesManager;
use wajox\yii2base\services\users\PrivacySettingsManager;

class DialogsController extends ApplicationController
{
    public function actionIndex()
    {
        $manager = $this->getDialogsManager();
        $query = $manager->getAllUserDialogsQuery();
        $countQuery = clone $query;
        $pages = $this->createObject(
            Pagination::className(),
            ['totalCount' => $countQuery->count()]
        );
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        $dialogIds = array_map(function ($userDialog) {
            return $userDialog->dialog_id;
        }, $models);

        $dialogsData = $manager->getDialogsDataByIds($dialogIds);
        $dialogsData['pages'] = $pages;
        $dialogsData['models'] = $models;

        return $this->render('index', $dialogsData);
    }

    public function actionView($id)
    {
        $dialog = $this->findModel($id);
        $manager = $this->getDialogsManager($dialog);
        $query = $manager->getDialogActiveMessageStatusesQuery();
        $countQuery = clone $query;
        $pages = $this->createObject(
            Pagination::className(),
            ['totalCount' => $countQuery->count()]
        );
        $statuses = $query->offset($pages->offset)->limit($pages->limit)->all();
        $messagesIds = array_map(function ($status) {
                return $status->message_id;
            }, $statuses);
        $messages = $manager->getMessagesByIds($messagesIds);
        $members = $manager->getMembersByDialogsIds([$dialog->id]);
        $messages = array_reverse($messages);

        foreach ($messages as $message) {
            $this->getMessagesManager()->readMessage($user, $message);
        }

        return $this->render('view', [
                'members' => $members,
                'messages' => $messages,
                'model' => $dialog,
                'pages' => $pages,
            ]);
    }

    public function actionCreate($userIds)
    {
        $userIds = is_array($userIds) ? $userIds : explode(',', $userIds);
        $manager = $this->getDialogsManager();
        $members = User::find()->where(['id' => $userIds])->all();
        $pm = $this->createObject(PrivacySettingsManager::className(), [$user]);
        $pm->addTargetUsersIds($userIds);

        foreach ($userIds as $userId) {
            if (!$pm->canWriteMessage($userId)) {
                throw new ForbiddenHttpException();
            }
        }

        if (!$manager->create($members)) {
            throw new HttpException(500);
        }

        if ($this->getApp()->request->isPost) {
            $postData = $this->getApp()->request->post();
            $message = $manager->sendMessage($postData);
        }

        return $this->redirect([
            '/profile/dialogs/view',
            'id' => $manager->dialog->id,
        ]);
    }

    public function actionDelete($id)
    {
        $user = $this->getApp()->user->identity;
        $model = $this->findModel($id);
        $manager = $this->getDialogsManager($model);
        $manager->leaveDialog();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Dialog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getDialogsManager($dialog = null)
    {
        return $this->createObject(
            DialogsManager::className(),
            [$this->getUser(), $dialog]
        );
    }

    protected function getMessagesManager()
    {
        return $this->getDependency(MessagesManager::className());
    }
}
