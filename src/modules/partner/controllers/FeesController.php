<?php
namespace wajox\yii2base\modules\partner\controllers;

use yii\data\ActiveDataProvider;

class FeesController extends ApplicationController
{
    public function actionIndex()
    {
        $partner = $this->getPartner();

        $query = $query = PartnerFee::find()->orderBy('created_at DESC')
            ->where(['partner_id' => $this->getPartner()->id]);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [[
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
