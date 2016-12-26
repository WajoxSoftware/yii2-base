<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\models\GoodPartnerProgram;
use yii\data\ActiveDataProvider;
use wajox\yii2base\models\Good;

class OffersController extends ApplicationController
{
    public function actionIndex()
    {
        $query = GoodPartnerProgram::find()->where([
                'partner_id' => [0, $this->getPartner()->id]
            ])->joinWith([
                'good' => function ($query) {
                        return $query->andWhere([
                            'status_id' => Good::STATUS_ID_ACTIVE,
                            'partner_status_id' => Good::PARTNER_STATUS_ID_ACTIVE,
                        ]);
                    },
            ]);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [['query' => $query]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
                'model' => $model,
                'partner' => $this->getPartner(),
            ]);
    }

    protected function findModel($id)
    {
        $model = GoodPartnerProgram::find()->where([
                'id' => $id,
                'partner_id' => [0, $this->getPartner()->id]
            ])->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
