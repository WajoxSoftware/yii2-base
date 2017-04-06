<?php
namespace wajox\yii2base\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;
use wajox\yii2base\models\PartnerFee;
use wajox\yii2base\modules\payment\models\Payment;
use wajox\yii2base\models\Order;
use wajox\yii2base\models\search\Partner as PartnerSearch;
use wajox\yii2base\services\users\PartnersBuilder;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Sort;

class PartnersController extends ApplicationController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = $this->createObject(PartnerSearch::className());
        $sort = $this->getSort();
        $dataProvider = $searchModel->search($this->getApp()->request->queryParams, $sort);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
        ]);
    }

    public function actionAllFees()
    {
        $query = $this
            ->getRepository()
            ->find(PartnerFee::className())
            ->orderBy('created_at DESC');

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('all_fees', [
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionAllPayments()
    {
        $query = $this
            ->getRepository()
            ->find(Payment::className())
            ->orderBy('created_at DESC');

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('all_payments', [
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionOrders($id)
    {
        $partner = $this->findModel($id);

        $query = $this
            ->getRepository()
            ->find(Order::className())
            ->orderBy('created_at DESC')
            ->joinWith([
                'customer' => function ($query) use ($partner) {
                    return $query->andWhere([
                            'referal_user_id' => $partner->id
                        ]);
                },
            ]);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('orders', [
                'model' => $partner,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionFees($id)
    {
        $partner = $this->findModel($id);

        $query = $this
            ->getRepository()
            ->find(PartnerFee::className())
            ->orderBy('created_at DESC')
            ->where(['partner_id' => $partner->id]);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('fees', [
                'model' => $partner,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionPayments($id)
    {
        $partner = $this->findModel($id);

        $query = $this
            ->getRepository()
            ->find(Payment::className())
            ->orderBy('created_at DESC')
            ->where(['user_id' => $partner->user->id]);

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('payments', [
                'model' => $partner,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $user = $this->createObject(User::className());
        $model = $this->createObject(Partner::className());
        $request = $this->getApp()->request;
        $builder = $this->createObject(PartnersBuilder::className(), [$user, $model]);

        if ($request->isPost
            && $builder->save($request)
        ) {
            return $this->redirect([
                'view',
                'id' => $builder->getModel()->id,
            ]);
        }

        return $this->render('create', [
            'model' => $builder->getModel(),
            'modelUser' => $builder->getUser(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = $model->user;
        $request = $this->getApp()->request;
        $builder = $this->createObject(PartnersBuilder::className(), [$user, $model]);

        if ($request->isPost
            && $builder->save($request)
        ) {
            return $this->redirect([
                'view',
                'id' => $builder->getModel()->id,
            ]);
        }

        return $this->render('update', [
            'model' => $builder->getModel(),
            'modelUser' => $builder->getUser(),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function getSort()
    {
        return $this->createObject(Sort::className(), [[
            'attributes' => [
                'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                'parent_partner_id' => ['label' => \Yii::t('app/attributes', 'Partner ID')],
                'subscribers_count' => ['label' => \Yii::t('app/attributes', 'Partner Subscribers Count')],
                'subscribes_count' => ['label' => \Yii::t('app/attributes', 'Partner Subscribes Count')],
                'sales_count' => ['label' => \Yii::t('app/attributes', 'Partner Sales Count')],
                'clicks_count' => ['label' => \Yii::t('app/attributes', 'Partner Clicks Count')],
                'sales_sum' => ['label' => \Yii::t('app/attributes', 'Partner Sales Sum')],
                'payments_sum' => ['label' => \Yii::t('app/attributes', 'Partner Payments Sum')],
                'url' => ['label' => \Yii::t('app/attributes', 'Url')],
                'city' => ['label' => \Yii::t('app/attributes', 'City')],
                'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],
            ],
        ]]);
    }

    protected function findModel($id)
    {
        $model =$this
            ->getRepository()
            ->find(Partner::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
