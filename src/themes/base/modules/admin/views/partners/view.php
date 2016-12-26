<?php
use yii\helpers\Url;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->render('_tabs_partner', [
  'current' => 'view',
  'model' => $model,
]);

echo $this->render('_partner_card', [
    'model' => $model,
]);
