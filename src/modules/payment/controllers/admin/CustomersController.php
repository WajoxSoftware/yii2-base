<?php
namespace wajox\yii2base\modules\payment\controllers\admin;

use wajox\yii2base\modules\payment\models\Customer;
use wajox\yii2base\modules\payment\models\search\CustomerSearch;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;

use yii\web\NotFoundHttpException;
use yii\data\Sort;
use yii\data\ActiveDataProvider;

class CustomersController extends AdminApplicationController
{
    public function actionIndex()
    {
        $sort = $this->getSort();
        $searchModel = $this->createObject(CustomerSearch::className());
        $params = $this->getApp()->request->queryParams;
        $dataProvider = $searchModel->search($params, $sort);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = \Yii::$app->request;

        $success = $request->isPost
            && $model->load($request->post())
            && $model->save();

        return $this->renderJs('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionView($id)
    {
        $request = $this->getApp()->request;
        $model = $this->findModel($id);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [[
                'query' => $model->getUserActionLogs(),
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ],
                ],
            ]]
        );

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    protected function getSort()
    {
        return new Sort([
            'attributes' => [
                'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                'email' => ['label' => \Yii::t('app/attributes', 'Email')],
                'phone' => ['label' => \Yii::t('app/attributes', 'Phone')],
                'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],
                'full_name' => ['label' => \Yii::t('app/attributes', 'Full Name')],
            ],
        ]);
    }

    protected function findModel($id)
    {
        return $this->findModelById(Customer::className(), $id);
    }
}
