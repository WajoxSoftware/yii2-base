<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\models\UserSubaccount;
use yii\web\NotFoundHttpException;

class UserSubaccountsController extends ApplicationController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->getPartner(),
        ]);
    }

    public function actionCreate()
    {
        $user_id = $this->getApp()->user->id;
        $model = $this->createObject(UserSubaccount::className());
        $model->user_id = $user_id;
        $request = $this->getApp()->request;

        $success = false;

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
        }

        return $this->renderJs('create', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = $this->getApp()->request;
        $success = false;

        if ($request->isPost) {
            $success = ($model->load($request->post()) && $model->save());
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
        $user_id = $this->getApp()->user->id;
        $model = UserSubaccount::find()
                    ->where(['user_id' => $user_id, 'id' => $id])
                    ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
