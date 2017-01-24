<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodEmailList;
use wajox\yii2base\modules\shop\models\EmailList;
use wajox\yii2base\modules\admin\ApplicationController as AdminApplicationController;
use yii\web\NotFoundHttpException;

class GoodEmailListsController extends AdminApplicationController
{
    public function actionCreate($id)
    {
        $model_good = $this->findGoodModel($id);
        $model = $this->createObject(GoodEmailList::className());
        $model->good_id = $model_good->id;
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->renderJs('delete', [
            'model' => $model,
        ]);
    }

    protected function findEmailListModel($id)
    {
        return $this->findModelById(EmailList::className(), $id);
    }

    protected function findModel($id)
    {
        return $this->findModelById(GoodEmailList::className(), $id);
    }

    protected function findGoodModel($id)
    {
        return $this->findModelById(Good::className(), $id);
    }
}
