<?php
namespace wajox\yii2base\modules\webinar\controllers\api;

use yii\web\NotFoundHttpException;
use wajox\yii2base\modules\webinar\models\Webinar;
use wajox\yii2base\modules\webinar\models\WebinarViewer;

class DefaultController extends ApplicationController
{
    public function actionView(int $id)
    {
        $manager = $this->getManager();
        $model = $manager->findModel($id);
        $viewersCount = $manager->getViewersCount($model);
        $viewersQuery = $model->getWebinarViewers()->online();

        try {
            // update viewer time
            $viewer = $manager->getCurrentViewer($model);
            $viewer->last_at = time();
            $viewer->save();

            $viewersQuery->exceptId($viewer->id);
        } catch (\Exception $e) {
            \Yii::trace($e->getMessage());
        }

        $viewers = $viewersQuery->all();
        $viewersCount += sizeof($viewers) + 1;

        return $this->renderJson('view', [
            'model' => $model,
            'viewers' => $viewers,
            'viewersCount' => $viewersCount,
        ]);
    }

    protected function getManager()
    {
        return $this->createObject(\wajox\yii2base\modules\webinar\services\WebinarManager::className());
    }
}
