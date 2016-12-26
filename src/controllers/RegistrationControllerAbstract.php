<?php
namespace wajox\yii2base\controllers;

use Yii;
use yii\filters\AccessControl;
use wajox\yii2base\services\users\UsersManager;
use wajox\yii2base\models\form\PartnerRegistrationForm;

abstract class RegistrationControllerAbstract extends \wajox\yii2base\controllers\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'partner'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'narrow';
        $model = $this->getRegistrationForm();
        if ($model->load($this->getApp()->request->post())) {
            if ($user = $model->signup()) {
                $this->getApp()->session->setFlash('success', \Yii::t('app/general', 'Registration email was sent'));

                $this->getUsersManagr()->signedUp($user);

                $this->afterSignUp($user);

                if ($this->getUsersManagr()->signIn($user)) {
                    return $this->goDashboard();
                } else {
                    return $this->goHome();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    protected function afterSignUp($user)
    {
        ;//\Yii::$app->visitor->assignPartner($user);
    }

    protected function getRegistrationForm()
    {
        return $this->createObject(PartnerRegistrationForm::className());
    }

    protected function getUsersManager()
    {
        return $this->getDependency(UsersManager::className());
    }
    
    abstract protected function goDashboard();
}
