<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\services\subscribes\EmailListBuilder;
use yii\web\NotFoundHttpException;

class EmailListsController extends ApplicationController
{
    public function actionIndex()
    {
        $query = $this
            ->getRepository()
            ->find(EmailList::className());

        return $this->render('index', [
            'query' => $query,
        ]);
    }

    public function actionCreate()
    {
        $request = $this->getApp()->request;
        $builder = $this->getBuilder();

        $success = false;

        if ($request->isPost
            && $builder->load($request)
            && $builder->save()
        ) {
            $success = true;
        }

        return $this->renderJs('create', [
            'model' => $builder->getEmailList(),
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
            'model' => $builder->getEmailList(),
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
            ->find(EmailList::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getBuilder($model = null)
    {
        $builder = $this->createObject(EmailListBuilder::className(), [$model]);

        return $builder->buildEmailList();
    }
}
