<?php
namespace wajox\yii2base\controllers;

use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\services\traffic\ClicksManager;
use wajox\yii2base\services\subaccounts\SubaccountsManager;
use wajox\yii2base\services\web\UrlConverter;

class TrafficStreamsController extends Controller
{
    public function actionView($tag = null)
    {
        $tags = explode('/', $tag);

        if (sizeof($tags) < 2) {
            throw new \NotFoundHttpException();
        } 

        $sourceTag = array_shift($tags);
        $source = $this->findSourceByTag($sourceTag);

        $streamTag = implode('/', $tags);

        $stream = $this->findStreamByTag($source, $streamTag);

        $this->registerStream($stream);

        return $this->redirect($source->getTargetUrl());
    }

    protected function findSourceByTag($tag)
    {
        $conditions = [
            'tag' => $tag,
            'status_id' => TrafficSource::STATUS_ID_ACTIVE,
        ];

        $model = $this
            ->getRepository()
            ->find(TrafficSource::className())
            ->where($conditions)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findStreamByTag($source, $tag)
    {
        $conditions = [
            'full_tag' => $tag,
            //'status_id' => TrafficStream::STATUS_ID_ACTIVE,
            'traffic_source_id' => $source->id,
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

    protected function registerStream($stream)
    {
        $this
            ->getApp()
            ->visitor
            ->setTrafficStream($stream);

        $this
            ->getClicksManager()
            ->save();
    }

    protected function getClicksManager()
    {
        return $this->getDependency(ClicksManager::className());
    }
}
