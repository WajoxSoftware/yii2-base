<?php

$this->title = $model->goodTitle;
$this->params['breadcrumbs'][] = [
    'label' => \Yii::t('app/partner', 'Nav Offers'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_offer_info', ['model' => $model]);
echo $this->render('_good_info', ['model' => $model->good]);
echo $this->render('_offer_links', ['model' => $model, 'partner' => $partner]);
