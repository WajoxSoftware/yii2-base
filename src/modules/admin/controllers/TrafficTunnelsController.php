<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\TrafficTunnel;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use wajox\yii2base\services\traffic\TrafficTunnelListing;
use wajox\yii2base\services\traffic\TrafficTunnelSources;
use wajox\yii2base\services\traffic\TrafficTunnelAnalyzer;

class TrafficTunnelsController extends ApplicationController
{
    public function actionIndex()
    {
        $query = TrafficTunnel::find();

        return $this->render('index', [
            'query' => $query,
        ]);
    }

    public function actionView($id, $typeId = null, $itemId = null)
    {
        $finishDate = date('d.m.Y');
        $startDate = date('d.m.Y', time() - 3600 * 24 * 7);
        $dataProvider = null;
        $model = $this->findModel($id);

        $analyzer = $this->createObject(
            TrafficTunnelAnalyzer::className(),
            [$model, $startDate, $finishDate]
        );

        $listing = $this->createObject(
            TrafficTunnelListing::className(),
            [$typeId, $itemId]
        );

        $sources = [];

        if (is_array($listing->getSources())) {
            $sources = $listing->getSources();
        } else {
            $dataProvider = $this->createObject(ActiveDataProvider::className(), [
                ['query' => $listing->getSources()],
            ]);

            foreach ($dataProvider->getModels() as $s) {
                $sources[] = $this
                    ->getSourcesManager()
                    ->getSourceData($s);
            }
        }

        $steps = $analyzer->setSources($sources)->loadData()->getData();

        return $this->render('view', [
            'model' => $model,
            'listing' => $listing,
            'sourcesData' => $sources,
            'stepsData' => $steps,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $request = $this->getApp()->request;
        $model = $this->createObject(TrafficTunnel::className());
        $success = false;

        if ($request->isPost
            &&  $model->load($request->post())
        ) {
            $success = $model->save();
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);
        $success = false;

        if ($request->isPost
            && $model->load($request->post())
        ) {
            $success = $model->save();
        }

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        $model = $this
                ->getRepository()
                ->find(TrafficTunnel::className)
                ->byId($id)
                ->one();
                
        if ($model == null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getSourcesManager()
    {
        return $this->getDependency(TrafficTunnelSources::className());
    }
}
