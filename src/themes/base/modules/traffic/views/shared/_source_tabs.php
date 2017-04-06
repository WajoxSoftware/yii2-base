<?php
$items = [];

$items['index'] = [
  'url' => ['view-source', 'id' => $model->id],
  'title' => \Yii::t('app/admin', 'Nav Traffic Source View'),
];

$items['stat'] = [
  'url' => ['view-source-stat', 'id' => $model->id],
  'title' => \Yii::t('app/admin', 'Nav Traffic Source Stat'),
];

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => $items,
];
