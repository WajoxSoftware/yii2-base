<?php
$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'email-lists' => [
      'url' => ['/admin/email-lists'],
      'title' => \Yii::t('app/admin', 'Nav Email Lists'),
    ],
    'subscribes' => [
      'url' => ['/admin/subscribes'],
      'title' => \Yii::t('app/admin', 'Nav Subscribes'),
    ],
  ],
];
