<?php


$items = [
  'index' => [
    'url' => ['index'],
    'title' => \Yii::t('app/profile', 'Nav Contacts List'),
  ],
  'requests' => [
    'url' => ['requests'],
    'title' => \Yii::t('app/profile', 'Nav Contacts Requests'),
  ],
  'find' => [
    'url' => ['find'],
    'title' => \Yii::t('app/profile', 'Nav Contacts Search'),
  ],

];

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => $items,
];
