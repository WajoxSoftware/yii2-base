<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodCategory;
use wajox\yii2base\modules\shop\services\GoodsManager;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class GoodsController extends AdminApplicationController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($id = null)
    {
        $sort = $this->getSort();
        $category = null;
        $categoryId = null;

        if ($id) {
            $category = $this->findCategoryModel($id);
            $categoryId = $category->id;
        }

        $categoriesQuery = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byParentId($categoryId);

        $query = $this
            ->getRepository()
            ->find(Good::className())
            ->byCategoryId($categoryId)
            ->orderBy($sort->orders);

        $categoriesDataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $categoriesQuery]]
        );

        $dataProvider = $this->createObject(
            ActiveDataProvider::className(),
            [['query' => $query]]
        );

        return $this->render('index', [
            'categoryId' => $categoryId,
            'category' => $category,
            'categoriesDataProvider' => $categoriesDataProvider,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
        ]);
    }

    public function actionView($id, $tab = 'info')
    {
        $tabs = [
            'info',
            'editor',
            'images',
            'egood_entities',
            'partners',
            'coupons',
            'letters',
            'email_lists',
        ];

        if (!in_array($tab, $tabs)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $request = $this->getApp()->request;
        $model = $this->findModel($id);
        $builder = $this->getBuilder($model);

        if ($request->isPost) {
            $builder->save($request);
        }

        return $this->render('view', [
            'model' => $builder->getForm(),
            'modelGood' => $builder->getGood(),
            'currentTab' => $tab,
        ]);
    }

    /*
    ** Create good with short way(with modal)
    */
    public function actionCreate($id, $typeId)
    {
        $request = $this->getApp()->request;
        $category = $this->findCategoryModel($id);
        $categoryId = $category->id;

        $model = $this->createObject(Good::className());
        $model->good_type_id = $typeId;

        $builder = $this->getBuilder($model)->setCategory($category)->build();
        $success = false;

        if ($request->isPost) {
            $success = $builder->save($request);
        }

        $data = [
            'model' => $builder->getForm(),
            'success' => $success,
        ];

        return  $this->asJs(function () use ($data) {
            return $data;
        })->renderFormat('create');
    }

    /*
    * Create draft according to another good attributes
    */
    public function actionDraft($typeId = null, $id = null, $cloneMode = false)
    {
        $request = $this->getApp()->request;

        if ($id) {
            $source = $this->findModel($id);
        } else {
            $source = $this->createObject(Good::className());
            $source->good_type_id = $typeId;
        }

        $builder = $this->getDraftsBuilder($source, $cloneMode);

        if ($builder->create()) {
            return $this->redirect(['view', 'id' => $builder->getGood()->id]);
        }

        $redirectPath = $source == null ? ['index'] : ['view', 'id' => $source->id];

        return $this->redirect($redirectPath);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $builder = $this->getBuilder($model)->build();
        $request = $this->getApp()->request;

        if ($request->isPost && $builder->save($request)) {
            return $this->redirect(['view', 'id' => $builder->getModel()->id]);
        }

        return $this->render('view', [
            'model' => $builder->getModel(),
        ]);
    }

    public function actionStatus($id, $statusId)
    {
        $model = $this->findModel($id);
        $model->status_id = $statusId;
        $model->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDelete($id)
    {
        $user  = $this->getUser();
        $model = $this->findModel($id);
        $manager = $this->createObject(GoodsManager::className(), [$user, $model]);
        $manager->delete();

        return $this->redirect(['index']);
    }

    protected function getSort()
    {
        return $this->createObject(Sort::className(), [[
            'attributes' => [
                'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                'user_id' => ['label' => \Yii::t('app/attributes', 'User ID')],
                'status_id' => ['label' => \Yii::t('app/attributes', 'Status ID')],
                'good_type_id' => ['label' => \Yii::t('app/attributes', 'Good Type ID')],
                'title' => ['label' => \Yii::t('app/attributes', 'Title')],
                'url' => ['label' => \Yii::t('app/attributes', 'Url')],
                'sum' => ['label' => \Yii::t('app/attributes', 'Price')],
                'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],
                'updated_at' => ['label' => \Yii::t('app/attributes', 'Status At')],
            ],
        ]]);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(Good::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findCategoryModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getBuilder($model = null)
    {
        $user = $this->getUser();
        $model = $model ? $model : $this->createObject(Good::className());
        $typeId = $model->good_type_id;

        $manager = $this->createObject(
            GoodsManager::className(),
            [$user, $model]
        );

        return $manager->getBuilder($typeId);
    }

    protected function getDraftsBuilder($model = null, $cloneMode = false)
    {
        $user = $this->getUser();

        $manager = $this->createObject(
            GoodsManager::className(),
            [$user, $this->createObject(Good::className())]
        );

        return $manager->getDraftsBuilder($model, $cloneMode);
    }
}
