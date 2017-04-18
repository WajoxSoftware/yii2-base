<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'view' => [
      'url' => ['view', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav Partners Partner Info'),
    ],
    'update' => [
      'url' => ['update', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav Partners Partner Update'),
    ],
    'orders' => [
      'url' => ['orders', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav Partners Partner Orders'),
    ],
    'fees' => [
      'url' => ['fees', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav Partners Partner Fees'),
    ],
    'payments' => [
      'url' => ['payments', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav Partners Partner Payments'),
    ],

  ],
];
