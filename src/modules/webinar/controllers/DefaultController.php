<?php
namespace wajox\yii2base\modules\webinar\controllers;

use wajox\yii2base\modules\webinar\models\Webinar;
use wajox\yii2base\modules\webinar\models\WebinarViewer;
use yii\web\NotFoundHttpException;

class DefaultController extends ApplicationController
{
    public function actionView(int $id, string $email = '')
    {
        $manager = $this->getManager();
        $webinar = $manager->findModel($id);

        try {
            $viewer = $manager->getCurrentViewer($webinar);
        } catch (\Exception $e) {
            return $this->redirect([
                'sign-in',
                'id' => $id,
                'email' => htmlspecialchars($email),
            ]);
        }
        
        return $this->render('view', [
            'model' => $webinar,
            'viewer' => $viewer,
        ]);
    }

    public function actionSignIn(int $id, $email = '')
    {
        $manager = $this->getManager();
        $webinar = $manager->findModel($id);
        $viewer = $manager
            ->startView(
                $webinar,
                $this->getAppRequest(),
                $email
            );

        if (!$viewer->isNewRecord) {
            return $this->redirect([
                'view',
                'id' => $webinar->id,
                'email' => $email,
            ]);
        }

        return $this->render('sign-in', [
            'model' => $viewer,
            'webinar' => $webinar,
        ]);
    }

    protected function getManager()
    {
        return $this->createObject(\wajox\yii2base\modules\webinar\services\WebinarManager::className());
    }
}
