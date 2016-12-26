<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'view' => [
      'url' => ['view', 'id' => $model->id],
      'title' => \Yii::t('app/admin', 'Nav User Info'),
    ],

    'map' => [
      'url' => ['map', 'id' => $model->id],
      'title' =>  \Yii::t('app/admin', 'Nav User Map'),
    ],

    'statistics' => [
      'url' => ['statistics', 'id' => $model->id],
      'title' =>  \Yii::t('app/admin', 'Nav User Actions'),
    ],
  ],
];
