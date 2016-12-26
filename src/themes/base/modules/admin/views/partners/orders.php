<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs_partner', [
  'current' => 'orders',
  'model' => $model,
]);

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_order_item',
]);
