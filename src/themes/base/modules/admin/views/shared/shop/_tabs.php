<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'orders' => [
      'url' => ['/admin/orders'],
      'title' => \Yii::t('app/admin', 'Nav Orders'),
    ],
    'customers' => [
      'url' => ['/admin/customers'],
      'title' => \Yii::t('app/admin', 'Nav Customers'),
    ],
  ],
];
