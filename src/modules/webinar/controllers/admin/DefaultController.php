<?php
namespace wajox\yii2base\modules\webinar\controllers\admin;

use wajox\yii2base\modules\webinar\models\Webinar;
use wajox\yii2base\modules\admin\controllers\ApplicationController as AdminApplicationController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class DefaultController extends AdminApplicationController
{
    public function actionIndex()
    {
        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => Webinar::find()]]
        );
        
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }


    public function actionCreate()
    {
        $request = $this->getApp()->request;
        $model = $this->buildModel();
        $success = false;

        if ($request->isPost
            && $model->load($request->post())
            && $model->save()
        ) {
            $success = true;
        }
        
        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate(int $id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);
        $success = false;

        if ($request->isPost
            && $model->load($request->post())
            && $model->save()
        ) {
            $success = true;
        }

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);

        $model->delete();

        return $this->renderJs('delete', ['model' => $model]);
    }

    protected function buildModel(): Webinar
    {
        $model = $this->createObject(Webinar::className());

        $model->names_dictionary = '';

        return $model;
    }

    protected function findModel(int $id): Webinar
    {
        $model = $this
            ->getRepository()
            ->find(Webinar::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
