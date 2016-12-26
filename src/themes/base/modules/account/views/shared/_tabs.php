<?php

$this->params['pageTabs'] = [
  'current' => $current,
  'items' => [
    'settings' => [
      'url' => ['/account/settings'],
      'title' => \Yii::t('app/account', 'Account Settings Info'),
    ],
    'security' => [
      'url' => ['/account/settings/security'],
      'title' => \Yii::t('app/account', 'Account Settings Security And Privacy'),
    ],
    'networks' => [
      'url' => ['/account/social-network-accounts'],
      'title' => \Yii::t('app/account', 'Account Social Network Accounts'),
    ],
  ],
];
