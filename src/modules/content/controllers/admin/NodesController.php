<?php
namespace wajox\yii2base\modules\content\controllers\admin;

use wajox\yii2base\modules\content\models\ContentNode;
use wajox\yii2base\modules\content\services\content\ContentNodesManager;
use wajox\yii2base\modules\admin\controllers\ApplicationController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class NodesController extends ApplicationController
{
    public function actionIndex($id = 0)
    {
        $parentNode = null;

        if ($id != 0) {
            $parentNode = $this->findModel($id);
        }

        $query = ContentNode::find()->where(['parent_node_id' => $id]);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [['query' => $query]]);

        return $this->render('index', [
            'parentNode' => $parentNode,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($typeId, $parentId = 0)
    {
        $request = $this->getApp()->request;
        $manager = $this->getManager();
        $manager->setTypeId($typeId);
        $success = false;

        if ($request->isPost && $manager->create($request, $parentId)) {
            $modelNode = $manager->getNode();
            $success = true;
        }

        $modelForm = $manager->getForm();

        return $this->renderJs('create', [
                'model' => $modelForm,
                'success' => $success,
            ]);
    }

    public function actionUpdate($id)
    {
        $modelNode = $this->findModel($id);
        $request = $this->getApp()->request;
        $manager = $this->getManager();
        $manager->setNode($modelNode);

        if ($request->isPost && $manager->update($request)) {
            $modelNode = $manager->getNode();

            return $this->redirect(['update', 'id' => $modelNode->id]);
        }

        $modelForm = $manager->getForm();

        return $this->render('update', [
                'model' => $modelForm,
                'modelNode' => $modelNode,
            ]);
    }

    public function actionDelete($id)
    {
        $modelNode = $this->findModel($id);

        $this->getManager()->setNode($modelNode)->delete();

        return $this->redirect(['index', 'id' => $modelNode->parent_node_id]);
    }

    public function actionPublish($id)
    {
        $modelNode = $this->findModel($id);

        $this->getManager()->setNode($modelNode)->publish();

        return $this->redirect(['index', 'id' => $modelNode->parent_node_id]);
    }

    public function actionArchive($id)
    {
        $modelNode = $this->findModel($id);

        $this->getManager()->setNode($modelNode)->Archive();

        return $this->redirect(['index', 'id' => $modelNode->parent_node_id]);
    }

    protected function findModel($id)
    {
        if (($model = ContentNode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getManager()
    {
        $user = $this->getUser();
        $manager = $this->createObject(ContentNodesManager::className(), [$user]);

        return $manager;
    }
}
