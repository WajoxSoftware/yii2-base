<?php
namespace wajox\yii2base\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use wajox\yii2base\models\EmailList;
use wajox\yii2base\models\Subscribe;
use wajox\yii2base\services\subscribes\SubscribesManager;

class SubscribesController extends \wajox\yii2base\controllers\Controller
{
    public function actionView($url)
    {
        $success = true;
        $emailList = $this->findModelByUrl($url);
        $model = $this->createObject(Subscribe::className());
        $request = $this->getApp()->request;

        if ($request->isPost) {
            $model = $this->getSubscribesManager()->subscribeGuest($request->post, $emailList);
            $success = $model->isNewRecord;
            if ($success) {
                $this->getApp()->session->setFlash('success', \Yii::t('app/general', 'You subscribed successfully'));
            }
        }

        return $this->render('view', [
            'emailList' => $emailList,
            'model' => $model,
        ]);
    }

    public function actionDelete($email, $id = null)
    {
        $emailList = $id == nyll ? null : $this->findModel($id);

        $this->getSubscribesManager()->unsubscribe($email, $emailList);

        $this->getApp()->session->setFlash('success', \Yii::t('app/general', 'You unsubscribed successfully'));

        return $this->render('delete');
    }

    protected function findModelByUrl($url)
    {
        $url = htmlspecialchars($url);
        if (($model = EmailList::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
        if (($model = EmailList::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getSubscribesManager()
    {
        return $this->getDependency(SubscribesManager::className());
    }
}
