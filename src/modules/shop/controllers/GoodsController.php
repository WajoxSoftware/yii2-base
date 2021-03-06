<?php
namespace wajox\yii2base\modules\shop\controllers;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodCategory;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\NotFoundHttpException;

class GoodsController extends ApplicationController
{
    use \wajox\yii2base\modules\shop\traits\CouponTrait;

    public function actionIndex($url = null)
    {
        $sort = $this->getSort();
        $category = null;
        $categoryId = 0;

        if ($url != null) {
            $category = $this->findCategoyModel($url);
            $categoryId = $category->id;
        }

        $categories = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->where([
                'parent_id' => $categoryId,
            ])
            ->all();

        $query = $this
            ->getRepository()
            ->find(Good::className())
            ->where(['category_id' => $categoryId])
            ->orderBy($sort->orders);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('index', [
            'categoryId' => $categoryId,
            'category' => $category,
            'categories' => $categories,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
        ]);
    }

    public function actionView($url)
    {
        $this->getClicksManager()->save();

        $model = $this->findModel($url);

        if (($result = $this->renderCoupon($model)) !== null) {
            return $result;
        }

        return $this->render('view', [
          'model' => $model,
        ]);
    }

    protected function findModel($url)
    {
        $model = $this
            ->getRepository()
            ->find(Good::className())
            ->byUrl($url)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findCategoyModel($url)
    {
        $model = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byUrl($url)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

    protected function getClicksManager()
    {
        return $this->getApp()->clicksManager;
    }
}
