<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\GoodCategory;
use wajox\yii2base\modules\shop\services\GoodCategoriesBuilder;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class GoodCategoriesController extends AdminApplicationController
{
    public function actionCreate($id = null)
    {
        $request = $this->getApp()->request;
        $builder = $this->getBuilder();
        $builder->setParentCategoryId($id);

        $success = false;

        if ($request->isPost
            && $builder->load($request)
            && $builder->save()
        ) {
            $success = true;
        }

        return $this->renderJs('create', [
            'model' => $builder->getGoodCategory(),
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = $this->getApp()->request;
        $builder = $this->getBuilder($model);

        $success = false;

        if ($request->isPost
            && $builder->load($request)
            && $builder->save()
        ) {
            $success = true;
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
        return $this->findModelById(GoodCategory::className(), $id);
    }

    protected function getBuilder($model = null)
    {
        $builder = $this->createObject(
            GoodCategoriesBuilder::className(),
            [$model]
        );

        return $builder->buildGoodCategory();
    }
}
