<?php
namespace wajox\yii2base\modules\partner\controllers;

use yii\data\ActiveDataProvider;

class PartnersController extends ApplicationController
{
    public function actionIndex()
    {
        $query = $this->getPartner()->getPartners();

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [
            ['query' => $query],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
