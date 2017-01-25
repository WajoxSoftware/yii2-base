<?php
namespace wajox\yii2base\controllers;

use wajox\yii2base\models\form\ConfirmationForm;
use wajox\yii2base\models\User;

class ConfirmationController extends \wajox\yii2base\controllers\Controller
{
    public function actionIndex()
    {
        $this->layout = 'narrow';
        $model = $this->createObject(ConfirmationForm::className());
        if ($model->load($this->getApp()->request->post())) {
            if ($model->process()) {
                $this->getApp()->session->setFlash(
                    'success',
                    \Yii::t(
                        'app/general',
                        'Confirmation email was sent'
                    )
                );

                $model = $this->createObject(ConfirmationForm::className());
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionConfirm($token)
    {
        $model = $this->getManager()->findUnConfirmedByToken($token);

        if ($model == null) {
            $this->getApp()->session->setFlash('success', \Yii::t('app/general', 'Can`t confirm user'));
        } else {
            $this->getManager()->confirmEmail($model);

            $this->getApp()->user->login($model);
            $this->getApp()->session->setFlash(
                'success',
                \Yii::t(
                    'app/general',
                    'E-mail was confirmed'
                )
            );

            return $this->redirect(['/account']);
        }

        return $this->redirect(['/confirmation']);
    }

    public function getManager()
    {
        return $this->getApp()->usersManager;
        ;
    }
}
