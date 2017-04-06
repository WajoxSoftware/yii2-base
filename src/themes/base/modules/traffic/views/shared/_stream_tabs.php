<?php
$items = [];

$items['index'] = [
  'url' => ['view-stream', 'id' => $model->id],
  'title' => \Yii::t('app/admin', 'Nav Traffic Stream View'),
];

$items['prices'] = [
  'url' => ['view-stream-prices', 'id' => $model->id,],
  'title' => \Yii::t('app/admin', 'Nav Traffic Stream Prices'),
];

$items['stat'] = [
  'url' => ['view-stream-stat', 'id' => $model->id,],
  'title' => \Yii::t('app/admin', 'Nav Traffic Stream Stat'),
];

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => $items,
];
