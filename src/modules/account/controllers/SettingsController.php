<?php
namespace wajox\yii2base\modules\account\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\UserSettings;
use wajox\yii2base\models\form\PasswordForm;
use wajox\yii2base\models\UploadedImage;
use wajox\yii2base\services\users\UsersManager;
use wajox\yii2base\services\uploads\UploadsManager;

class SettingsController extends ApplicationController
{
    public function actionIndex()
    {
        $request = $this->getApp()->request;

        if (!$this->getUser()->isConfirmed()) {
            $this->getApp()->session->setFlash('error', \Yii::t('app', 'E-mail not confirmed'));
        }

        $modelUser = $this->updateUser($request);
        $modelAvatar = $this->updateUserAvatar($request);

        return $this->render('index', [
            'modelUser' => $modelUser,
            'modelAvatar' => $modelAvatar,
        ]);
    }

    public function actionSecurity()
    {
        $request = $this->getApp()->request;

        $modelSettings = $this->updateSettings($request);
        $modelPassword = $this->updatePassword($request);

        return $this->render('security', [
            'modelSettings' => $modelSettings,
            'modelPassword' => $modelPassword,
        ]);
    }

    public function actionDeleteAvatar()
    {
        $user = $this->getUser();

        if ($user->avatarImage) {
            $manager = $this->getUploadsManager($user);
            $manager->remove($user->avatarImage->id);
            $user->avatar_file_id = 0;
            $user->save();
        }

        return $this->redirect(['index']);
    }

    public function actionResendConfirmation()
    {
        $user = $this->getUser();
        $manager = $this->getUsersManager();
        $manager->sendConfirmationEmail($user);

        $this->getApp()->session->setFlash('success', \Yii::t('app', 'Confirmation email was sent'));

        return $this->redirect(['index']);
    }

    protected function updateUser($request)
    {
        $model = $this->getUser();

        if ($request->isPost
            && $model->load($request->post())
            && $model->save()
        ) {
            $this->getApp()->session->setFlash('success', \Yii::t('app', 'User settings was saved'));
        }

        return $model;
    }

    protected function updateSettings($request)
    {
        $user = $this->getUser();
        $model = $user->settings ?: $this->createObject(UserSettings::className());
        $success = false;

        if ($request->isPost
            && $model->load($request->post())
        ) {
            $model->id = $user->id;
            $success = $model->save();
        }

        if ($success) {
            $this->getApp()->session->setFlash('success', \Yii::t('app', 'User settings was saved'));
        }

        return $model;
    }

    protected function updatePassword($request)
    {
        $model = $this->createObject(PasswordForm::className());
        if ($request->isPost
            && $model->load($request->post())
            && $model->process()
        ) {
            $this->getApp()->session->setFlash('success', \Yii::t('app', 'Password was changed'));
        }

        return $model;
    }

    protected function updateUserAvatar($request)
    {
        $user = $this->getUser();
        $user->scenario = 'upload_avatar';
        $model = $user->avatarImage ?: $this->createObject(UploadedImage::className());

        if ($request->isPost) {
            $manager = $this->getUploadsManager($user);
            $model = $manager->replace($model, $request);
            $user->avatar_file_id = $model->id;

            if ($user->save()) {
                $this->getApp()->session->setFlash('success', \Yii::t('app', 'User settings was saved'));
            }
        }

        $this->getUser()->refresh();

        return $model;
    }

    protected function getUsersManager()
    {
        return $this->getDependency(UsersManager::className());
    }

    protected function getUploadsManager($user)
    {
        return $this->createObject(UploadsManager::className(), [$user]);
    }
}
