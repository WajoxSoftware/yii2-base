<?php
use yii\helpers\Url;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs_partner', [
  'current' => 'update',
  'model' => $model,
]);

echo $this->render('_form', [
    'model' => $model,
    'modelUser' => $modelUser,
]);
