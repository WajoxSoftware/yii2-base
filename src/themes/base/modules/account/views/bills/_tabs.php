<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'index' => [
      'url' => ['index'],
      'title' => \Yii::t('app/profile', 'Nav Bills Bills List'),
    ],
    'payments' => [
      'url' => ['payments'],
      'title' => \Yii::t('app/profile', 'Nav Bills Payments List'),
    ],
  ],
];
