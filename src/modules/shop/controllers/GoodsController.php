<?php
namespace wajox\yii2base\modules\shop\controllers;

use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\traffic\ClicksManager;
use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodCategory;

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

        $categories = GoodCategory::find()->where([
                'parent_id' => $categoryId,
            ])->all();

        $query = Good::find()->where(['category_id' => $categoryId])->orderBy($sort->orders);

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
        if (($model = Good::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCategoyModel($url)
    {
        if (($model = GoodCategory::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        return $this->getDependency(ClicksManager::className());
    }
}
