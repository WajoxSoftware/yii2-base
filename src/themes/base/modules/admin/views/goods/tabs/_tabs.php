<?php
$items = [];

$items['info'] = [
  'url' => ['view', 'id' => $model->getModel()->id],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Info'),
];

$items['editor'] = [
  'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'editor'],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Editor'),
];

if ($model->getModel()->isElectronic) {
    $items['egood_entities'] = [
      'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'egood_entities'],
      'title' => \Yii::t('app/admin', 'Nav Goods EGood Entities'),
    ];
}

$items['images'] = [
  'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'images'],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Images'),
];

$items['coupons'] = [
  'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'coupons'],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Coupons'),
];

$items['email_lists'] = [
  'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'email_lists'],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Email Lists'),
];

$items['letters'] = [
  'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'letters'],
  'title' => \Yii::t('app/admin', 'Nav Goods Good Letters'),
];

if ($model->getModel()->isPartnerProgramActive) {
    $items['partners'] = [
      'url' => ['view', 'id' => $model->getModel()->id, 'tab' => 'partners'],
      'title' => \Yii::t('app/admin', 'Nav Goods Good Partners'),
    ];
}

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => $items,
];
