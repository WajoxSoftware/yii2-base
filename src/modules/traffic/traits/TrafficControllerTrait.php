<?php
namespace wajox\yii2base\modules\traffic\traits;

use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use wajox\yii2base\models\User;
use wajox\yii2base\models\TrafficManager;
use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\TrafficStreamPrice;
use wajox\yii2base\models\form\StatisticFilterForm;

trait TrafficControllerTrait
{
    protected function viewManagersList()
    {
        $query = TrafficManager::find();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('view_managers_list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function viewUser($id)
    {
        $user = $this->findUser($id);

        $query = TrafficSource::find()->where([
                'user_id' => $user->id,
                'parent_source_id' => 0,
            ]);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('view_user', [
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    protected function viewSource($id)
    {
        $source = $this->findSourceModel($id);
        $user = $source->user;

        if ($source->hasSources) {
            $query = TrafficSource::find()->where([
                'parent_source_id' => $source->id,
            ]);
        } else {
            $query = TrafficStream::find()->where([
                'traffic_source_id' => $source->id,
            ]);
        }

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('view_source', [
            'searchModel' => $this->getFilterForm($user),
            'dataProvider' => $dataProvider,
            'source' => $source,
            'user' => $user,
        ]);
    }

    protected function viewStream($id)
    {
        $stream = $this->findStreamModel($id);
        $source = $stream->source;
        $user = $source->user;

        $query = TrafficStreamPrice::find()->where([
            'traffic_stream_id' => $stream->id,
        ]);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('view_stream', [
            'dataProvider' => $dataProvider,
            'source' => $source,
            'stream' => $stream,
            'user' => $user,
        ]);
    }

    protected function getFilterForm($user)
    {
        $request = $this->getApp()->request;
        $searchModel = $this->createObject(StatisticFilterForm::className());
        $searchModel->setUser($user);
        $searchModel->load($request->post());
        $searchModel->validate();
        $searchModel->compute();

        return $searchModel;
    }

    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSourceModel($id)
    {
        if (($model = TrafficSource::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findStreamModel($id)
    {
        if (($model = TrafficStream::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
