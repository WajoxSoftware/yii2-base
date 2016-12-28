<?php
namespace wajox\yii2base\modules\trafficmanager\controllers;

use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\models\TrafficStream;
use yii\web\NotFoundHttpException;

class TrafficController extends ApplicationController
{
    use \wajox\yii2base\modules\traffic\traits\TrafficControllerTrait;

    public function actionIndex()
    {
        return $this->viewUser($this->getUser()->id);
    }

    public function actionViewSource($id)
    {
        return $this->viewSource($id);
    }

    public function actionViewStream($id)
    {
        return $this->viewStream($id);
    }

    protected function findSourceModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficSource::className())
            ->where([
                'id' => $id,
                'user_id' => $this->getUser()->id,
            ])
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findStreamModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->where([
                'id' => $id,
                'user_id' => $this->getUser()->id,
            ])
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
