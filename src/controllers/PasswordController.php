<?php
namespace wajox\yii2base\controllers;

use Yii;
use wajox\yii2base\models\form\ResetPasswordForm;

class PasswordController extends \wajox\yii2base\controllers\Controller
{
    public function actionIndex()
    {
        $this->layout = 'narrow';
        $model = $this->createObject(ResetPasswordForm::className());
        $success = false;
        if ($model->load($this->getApp()->request->post()) && $model->process()) {
            $success = true;
            $this->getApp()->session->setFlash(
                'success',
                \Yii::t('app/general', 'Confirmation email was sent')
            );
        }

        return $this->render('index', [
            'model' => $model,
            'success' => $success,
        ]);
    }
}
