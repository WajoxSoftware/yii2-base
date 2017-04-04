<?php
$items = [];

$items['index'] = [
  'url' => ['view', 'id' => $model->id],
  'title' => \Yii::t('app/admin', 'Nav Traffic Source View'),
];

$items['stat'] = [
  'url' => ['view', 'id' => $model->id, 'stat' => false],
  'title' => \Yii::t('app/admin', 'Nav Traffic Source Stat'),
];

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => $items,
];
