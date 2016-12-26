<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Bills');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'index']);
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app', 'Update Balance'),
  'url' => ['create'],
  'icon' => 'fa-plus',
];

echo $this->render('_tabs', ['current' => 'index']);

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'status'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_bill_item',
]);
