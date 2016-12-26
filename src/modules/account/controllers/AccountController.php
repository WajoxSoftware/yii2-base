<?php
namespace wajox\yii2base\modules\account\controllers;

use yii\filters\AccessControl;
use yii\base\ActionEvent;
use yii\web\NotFoundHttpException;
use wajox\yii2base\models\User;
use wajox\yii2base\services\users\PrivacySettingsManager;
use wajox\yii2base\services\message\ContactsManager;

class AccountController extends ApplicationController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $event = $this->createObject(ActionEvent::className(), [$action]);
        $this->trigger(self::EVENT_BEFORE_ACTION, $event);

        return $event->isValid;
    }

    public function actionIndex()
    {
        if ($this->getApp()->user->isGuest) {
            $this->signInRedirect();
        }

        return $this->redirect(['/account/default/view', 'id' => $this->getApp()->user->id]);
    }

    public function actionView($id)
    {
        $model = $this->findUserModel($id);
        $contactsManager = $this->getContactsManager();
        $pm = $this->getPrivacyManager()->addTargetUsersIds([$model->id]);

        $viewAccess         = $pm->canView($model->id);
        $viewContactsAccess = $pm->canViewContacts($model->id);
        $writeMessageAccess = $pm->canWriteMessage($model->id);
        $addAccess          = $pm->canAdd($model->id);

        if (!$viewAccess) {
            return $this->render('forbidden', [
                    'model' => $model,
                ]);
        }

        return $this->render('view', [
                'model' => $model,
                'viewAccess' => $viewAccess,
                'viewContactsAccess' => $viewContactsAccess,
                'writeMessageAccess' => $writeMessageAccess,
                'addAccess' => $addAccess,
                'contactsManager' => $contactsManager,
            ]);
    }

    protected function getPrivacyManager()
    {
        $user = $this->getUser();

        return $this->createObject(PrivacySettingsManager::className(), [$user]);
    }

    protected function getContactsManager()
    {
        $user  = $this->getUser();

        return $this->createObject(ContactsManager::className(), [$user]);
    }

    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
