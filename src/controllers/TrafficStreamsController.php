<?php
namespace wajox\yii2base\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\services\traffic\ClicksManager;
use wajox\yii2base\services\subaccounts\SubaccountsManager;
use wajox\yii2base\services\web\UrlConverter;

class TrafficStreamsController extends Controller
{
    public function actionView($id, $tag = null)
    {
        $model = $this->findModel($id);

        $isIternalRedirect = $this->isInternalRedirect($model);
        $targetUrl = $this->getTargetUrl($model);

        $this->registerStream($model, $tag, $isIternalRedirect);

        return $this->redirect($targetUrl);
    }

    protected function getSubaccount($user, $tag)
    {
        $subaccountsManager = $this->getSubaccountsManager($user);
        $subaccount = $subaccountsManager->getSubaccount($tag);

        return $subaccount;
    }

    protected function findModel($id)
    {
        $conditions = [
            'id' => $id,
            'status_id' => TrafficStream::STATUS_ID_ACTIVE,
        ];

        $model = $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->where($conditions)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function registerStream($model, $tag, $isIternalRedirect)
    {
        $subaccount = $this->getSubaccount($model->user, $tag);

        $this->getApp()->visitor->setUserSubaccount($subaccount);
        $this->getApp()->visitor->setTrafficStream($model);

        if ($isIternalRedirect) {
            return;
        }

        $this->getClicksManager()->save();
    }

    protected function isInternalRedirect($model)
    {
        $converter = $this->getUrlConverter();

        $url = $converter->extract($model->target_url);

        return is_array($url);
    }

    protected function getTargetUrl($model)
    {
        $converter = $this->getUrlConverter();

        $url = $converter->extract($model->target_url);

        if (!is_array($url)) {
            return $url;
        }

        if (isset($url['model']) && $url['model'] != null) {
            return Url::toRoute([
                '/shop/goods/view',
                'url' => $url['model']->url,
            ]);
        }

        throw new NotFoundHttpException('Unknown target url');
    }

    protected function getUrlConverter()
    {
        return $this->getDependency(UrlConverter::className());
    }

    protected function getSubaccountsManager($user)
    {
        return $this->createObject(SubaccountsManager::className(), [$user]);
    }

    protected function getClicksManager()
    {
        return $this->getDependency(ClicksManager::className());
    }
}
