<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'index' => [
      'url' => ['index'],
      'title' => \Yii::t('app/admin', 'Nav Partners Partners List'),
    ],
    'all-fees' => [
      'url' => ['all-fees'],
      'title' => \Yii::t('app/admin', 'Nav Partners Fees'),
    ],
    'all-payments' => [
      'url' => ['all-payments'],
      'title' => \Yii::t('app/admin', 'Nav Partners Payments'),
    ],
  ],
];
