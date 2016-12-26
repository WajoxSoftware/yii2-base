<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\ContentNode;
use wajox\yii2base\models\UploadedImage;
use wajox\yii2base\services\content\ContentNodesManager;
use wajox\yii2base\modules\admin\ApplicationController;
use yii\web\NotFoundHttpException;

class ContentNodePreviewsController extends ApplicationController
{
    public function actionCreate($nodeId)
    {
        $request = $this->getApp()->request;
        $modelNode = $this->findNodeModel($nodeId);
        $modelFile = $this->createObject(UploadedImage::className());
        $success = false;

        if ($request->isPost) {
            $modelFile = $this->getManager()
                ->setNode($modelNode)
                ->savePreview($request);

            $success = !$modelFile->isNewRecord;
        }

        return $this->renderJs('create', [
                'model' => $modelNode,
                'model' => 'model',
                'success' => $success,
            ]);
    }

    public function actionDelete($nodeId)
    {
        $modelNode = $this->findNodeModel($nodeId);

        $this->getManager()->setNode($modelNode)->deletePreview();

        return $this->renderJs('delete');
    }

    public function getManager()
    {
        $user = $this->getUser();

        return  $this->createObject(ContentNodesManager::className(), [$user]);
    }

    protected function findNodeModel($id)
    {
        if (($model = ContentNode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
