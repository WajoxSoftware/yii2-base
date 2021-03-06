<?php
namespace wajox\yii2base\modules\payment\controllers\profile;

use wajox\yii2base\models\User;
use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\modules\payment\models\Payment;
use wajox\yii2base\modules\payment\models\Customer;
use wajox\yii2base\modules\payment\models\BillSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use wajox\yii2base\modules\account\controllers\ApplicationController as AccountApplicationController;

class BillsController extends AccountApplicationController
{
    public function actionIndex()
    {
        $searchModel = $this->createObject(BillSearch::className());
        $dataProvider = $searchModel->search(
            $this->getApp()->request->queryParams,
            $this->getUser()
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPayments()
    {
        $query = $this->getUser()->getPayments();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [[
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]]);

        return $this->render('payments', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $user = $this->getUser();
        $request = $this->getApp()->request;
        $model = $this->createObject(Bill::className());
        $customer = $this->createObject(Customer::className());

        if ($request->isPost) {
            $builder = $this
                ->getCustomersManager()
                ->createBuilder($request, $user);

            $saved = $builder->save();
            $customer = $builder->getCustomer();

            if ($saved) {
                $model = $this
                    ->getBillsManager()
                    ->create($request->post(), $customer);
                    
                if (!$model->isNewRecord) {
                    return $this->redirect([
                        '/payment/default/index',
                        'id' => $model->id,
                    ]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'customer_model' => $customer,
        ]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $this->getBillsManager()->cancelled($model);

        return $this->redirect(['view', 'id' => $model->id]);
    }

    protected function findModel($id)
    {
        $model = $this->findModelById(Bill::className(), $id);
        
        if ($model->isOwner($this->getUser()->id)) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function renderBillsByStatus($status = 'new')
    {
        $user_id = $this->getApp()->user->id;
        $query = $this
            ->getUser()
            ->getBills()
            ->where(['status' => $status]);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [[
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ],
                ],
            ]]
        );

        return $this->render($status, [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function getBillsManager()
    {
        return $this->getApp()->billsManager;
    }

    protected function getCustomersManager()
    {
        return $this->getApp()->customersManager;
    }
}
