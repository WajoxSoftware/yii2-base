<?php
namespace wajox\yii2base\controllers;

use wajox\yii2base\models\ContentNode;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ContentNodesController extends \wajox\yii2base\controllers\Controller
{
    public function actionView($url)
    {
        $this->layout = "//main";
        
        $model = $this->findModel($url);

        $dataProvider = $this->creteObject(ActiveDataProvider::className(), [
            ['query' => $model->getContentNodes()],
        ]);

        if ($model->layout == ContentNode::LAYOUT_EMPTY) {
            $this->layout = false;
        } else {
            $this->layout = $model->layout;
        }

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($url)
    {
        $conditions = ['url' => $url];

        if (($model = ContentNode::find()->where($conditions)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
