<?php
namespace wajox\yii2base\controllers;

use Yii;
use yii\filters\AccessControl;
use wajox\yii2base\models\form\LoginForm;
use wajox\yii2base\services\wajox_software\NetworkAccountsManager;

abstract class SessionControllerAbstract extends \wajox\yii2base\controllers\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'ulogin') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = 'narrow';

        if (!$this->getApp()->user->isGuest) {
            return $this->goDashboard();
        }

        $model = $this->getLoginForm();
        if ($model->load($this->getApp()->request->post()) && $model->login()) {
            return $this->goLoginPage();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionUlogin()
    {
        $token = $_REQUEST['token'];
        $manager = $this->getNetworkAccountManager();
        $params = $manager->getUloginData($token);

        if (sizeof($params) == 0) {
            return $this->goLoginPage();
        }

        $networkAccount = $manager->findAccount($params);

        if (!$networkAccount) {
            return $this->goLoginPage();
        }

        if (!$this->getLoginForm()
            ->setUser($networkAccount->user)
            ->login()
        ) {
            return $this->goLoginPage();
        }

        return $this->goDashboard();
    }

    public function actionLogout()
    {
        $this->getUsersManager()->signOut();

        return $this->goHome();
    }

    protected function getLoginForm()
    {
        return $this->createObject(LoginForm::className());
    }

    protected function getUsersManager()
    {
        return $this->getApp()->usersManager;
    }

    protected function getNetworkAccountManager()
    {
        return $this->getDependency(NetworkAccountsManager::className());
    }

    abstract protected function goDashboard();

    abstract protected function goLoginPage();
}
