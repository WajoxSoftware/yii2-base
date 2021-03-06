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
use wajox\yii2base\services\traffic\TrafficStreamStatisticAnalyzer;

trait TrafficControllerTrait
{
    protected function viewManagersList()
    {
        $query = $this
            ->getRepository()
            ->find(TrafficManager::className());

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

        $query = $this
            ->getRepository()
            ->find(TrafficSource::className())
            ->where([
                'user_id' => $user->id,
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
        $streams = [];

        $query = $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->where([
                'traffic_source_id' => $source->id,
            ])
            ->orderBy('level ASC');

        foreach ($query->each() as $stream) {
            $streams[$stream->parent_id][] = $stream;
        }

        return $this->render('view_source', [
            'searchModel' => $this->getFilterForm($user),
            'streams' => $streams,
            'source' => $source,
            'user' => $user,
        ]);
    }

    protected function viewSourceStat($id)
    {
        $source = $this->findSourceModel($id);
        $user = $source->user;
        $streams = [];

        $query = $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->where([
                'traffic_source_id' => $source->id,
            ])
            ->orderBy('level ASC');

        foreach ($query->each() as $stream) {
            $streams[$stream->parent_id][] = $stream;
        }

        return $this->render('view_source_stat', [
            'searchModel' => $this->getFilterForm($user),
            'streams' => $streams,
            'source' => $source,
            'user' => $user,
        ]);
    }

    protected function viewStream($id)
    {
        $stream = $this->findStreamModel($id);
        $source = $stream->source;
        $user = $source->user;

        return $this->render('view_stream', [
            'source' => $source,
            'stream' => $stream,
            'user' => $user,
        ]);
    }


    protected function viewStreamPrices($id)
    {
        $stream = $this->findStreamModel($id);
        $source = $stream->source;
        $user = $source->user;

        $query = $this
            ->getRepository()
            ->find(TrafficStreamPrice::className())
            ->where([
                'traffic_stream_id' => $stream->id,
            ]);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('view_stream_prices', [
            'dataProvider' => $dataProvider,
            'source' => $source,
            'stream' => $stream,
            'user' => $user,
        ]);
    }


    protected function viewStreamStat($id)
    {
        $stream = $this->findStreamModel($id);
        $source = $stream->source;
        $user = $source->user;

        $searchModel = $this->getFilterForm($user);
        $statRows = $this->getStreamStatRows($stream, $searchModel);

        return $this->render('view_stream_stat', [
            'searchModel' => $searchModel,
            'source' => $source,
            'stream' => $stream,
            'user' => $user,
            'statRows' => $statRows,
        ]);
    }

    protected function getFilterForm($user)
    {
        $request = $this
            ->getApp()
            ->request;

        $searchModel = $this->createObject(
            StatisticFilterForm::className()
        );

        $searchModel->setUser($user);
        $searchModel->load($request->post());
        $searchModel->validate();
        $searchModel->compute();

        return $searchModel;
    }

    protected function findUser($id)
    {
        $model =$this
            ->getRepository()
            ->find(User::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSourceModel($id)
    {
        $model =$this
            ->getRepository()
            ->find(TrafficSource::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findStreamModel($id)
    {
        $model =$this
            ->getRepository()
            ->find(TrafficStream::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getStreamStatRows($stream, $search)
    {
        $dateSteps = $search->getComputedIntervalSteps();

        $rows = [];

        foreach ($dateSteps as $dateStep) {
            $stat = $this->createObject(
                TrafficStreamStatisticAnalyzer::className(),
                [
                    $stream,
                    'custom',
                    date('d.m.Y', $dateStep['startAt']),
                    date('d.m.Y', $dateStep['finishAt']),
                    []
                ]
            );

            $rows[] = [
                'step' => $dateStep,
                'stat' => $stat->compute(),
            ];
        }
        
        return $rows;
    }
}
