<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\UserSubaccount;
use yii\web\NotFoundHttpException;

class UserSubaccountsController extends ApplicationController
{
    public function actionCreate($id)
    {
        $model_user = $this->findUserModel($id);

        $model = $this->createObject(UserSubaccount::className());
        $model->user_id = $model_user->id;
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
        return $this->findModelById(
            UserSubaccount::className(),
            $id
        );
    }

    protected function findUserModel($id)
    {
        return $this->findModelById(User::className(), $id);
    }
}
