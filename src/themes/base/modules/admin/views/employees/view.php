<?php
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'view', 'model' => $model]);

echo $this->render('_form', [
  'model' => $model,
]);
