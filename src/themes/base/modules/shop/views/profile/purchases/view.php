<?php
$this->title = $model->good->title;
$this->params['breadcrumbs'][] = [
    'url' => ['index'],
    'label' => \Yii::t('app/profile', 'Nav Purchases'),
];
$this->params['breadcrumbs'][] = $this->title;

$tpl = $model->good->isElectronic ? '_view_egood' : '_view_good';

echo $this->render($tpl, ['model' => $model->good]);
