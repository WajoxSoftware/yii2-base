<?php
use yii\helpers\Url;

$user = \Yii::$app->user->identity;
$parts = [];

$parts[] = [
    'title' => \Yii::t('app/profile', 'Nav Title'),
    'url' => Url::toRoute(['/account']),
    'items' => [
      ['title' => \Yii::t('app/profile', 'Nav Contacts'),'url' => Url::toRoute('/account/user-contacts'), 'icon' => 'fa-book'],
        ['title' => \Yii::t('app/profile', 'Nav Dialogs'), 'url' => Url::toRoute('/account/dialogs'), 'icon' => 'fa-envelope'],
        ['title' => \Yii::t('app/profile', 'Nav Purchases'), 'url' => Url::toRoute('/account/purchases'), 'icon' => 'fa-shopping-cart'],
        ['title' => \Yii::t('app/profile', 'Nav Bills'), 'url' => Url::toRoute('/payment/profile/bills'), 'icon' => 'fa-credit-card'],
        ['title' => \Yii::t('app/profile', 'Nav Notifications'), 'url' => Url::toRoute('/account/notifications'), 'icon' => 'fa-exclamation-circle'],
        ['title' => \Yii::t('app/profile', 'Nav Logout'), 'url' => Url::toRoute('/account/session/logout'), 'icon' => 'fa-sign-out'],
    ],
  ];

if ($user->isAdmin) {
    $parts[] = [
        'title' => \Yii::t('app/admin', 'Nav Title'),
        'url' => Url::toRoute(['/admin']),
        'items' => [
          ['url' => Url::toRoute('/admin'), 'title' => \Yii::t('app/admin', 'Nav Home'), 'icon' => 'fa-dashboard'],
          ['url' => Url::toRoute('/admin/employees'), 'title' => \Yii::t('app/admin', 'Nav Employees'), 'icon' => 'fa-university'],
          ['url' => Url::toRoute('/admin/users'), 'title' => \Yii::t('app/admin', 'Nav Users'), 'icon' => 'fa-users'],
          ['url' => Url::toRoute('/content/admin/nodes'), 'title' => \Yii::t('app/admin', 'Nav Content Nodes'), 'icon' => 'fa-newspaper-o'],
          ['url' => Url::toRoute('/shop/admin/goods'), 'title' => \Yii::t('app/admin', 'Nav Goods'), 'icon' => 'fa-shopping-basket'],
          ['url' => Url::toRoute('/payment/admin/customers'), 'title' => \Yii::t('app/admin', 'Nav Customers'), 'icon' => 'fa-mobile-phone'],
          ['url' => Url::toRoute('/payment/admin/orders'), 'title' => \Yii::t('app/admin', 'Nav Orders'), 'icon' => 'fa-shopping-cart'],
          ['url' => Url::toRoute('/payment/admin/bills'), 'title' => \Yii::t('app/admin', 'Nav Bills'), 'icon' => 'fa-credit-card'],
          ['url' => Url::toRoute('/admin/partners'), 'title' => \Yii::t('app/admin', 'Nav Partners'), 'icon' => 'fa-male'],
          ['url' => Url::toRoute('/admin/traffics'), 'title' => \Yii::t('app/admin', 'Nav Traffics'), 'icon' => 'fa-exchange'],
          ['url' => Url::toRoute('/admin/traffic-tunnels'), 'title' => \Yii::t('app/admin', 'Nav Traffic tunnels'), 'icon' => 'fa-filter'],
          ['url' => Url::toRoute('/admin/email-lists'), 'title' => \Yii::t('app/admin', 'Nav Email Lists'), 'icon' => 'fa-send'],
          ['url' => Url::toRoute('/admin/activity'), 'title' => \Yii::t('app/admin', 'Nav Activity'), 'icon' => 'fa-bar-chart'],
          ['url' => Url::toRoute('/admin/settings'), 'title' => \Yii::t('app/admin', 'Nav Settings'), 'icon' => 'fa-gear'],
        ],
      ];
}
if ($user->isPartner) {
    $parts[] = [
        'title' => \Yii::t('app/partner', 'Nav Title'),
        'url' => Url::toRoute(['/partner']),
        'items' => [
          ['title' => \Yii::t('app/partner', 'Nav Statistic'), 'url' => Url::toRoute('/partner'), 'icon' => 'fa-bar-chart'],
          ['title' => \Yii::t('app/partner', 'Nav Subaccounts'), 'url' => Url::toRoute('/partner/user-subaccounts'), 'icon' => 'fa-users'],
          ['title' => \Yii::t('app/partner', 'Nav Offers'), 'url' => Url::toRoute('/partner/offers'), 'icon' => 'fa-shopping-cart'],
          ['title' => \Yii::t('app/partner', 'Nav Traffic'), 'url' => Url::toRoute('/partner/traffic'), 'icon' => 'fa-exchange'],
          ['title' => \Yii::t('app/partner', 'Nav Settings'), 'url' => Url::toRoute('/partner/settings'), 'icon' => 'fa-cog'],
        ],
      ];
}

if ($user->isManager) {
    $parts[] = [
        'title' => \Yii::t('app/trafficmanager', 'Nav Title'),
        'url' => Url::toRoute(['/trafficmanager']),
        'items' => [
          ['title' => \Yii::t('app/trafficmanager', 'Nav Statistic'), 'url' => Url::toRoute('/trafficmanager'), 'icon' => 'fa-bar-chart'],
          ['title' => \Yii::t('app/trafficmanager', 'Nav Subaccounts'), 'url' => Url::toRoute('/trafficmanager/user-subaccounts'), 'icon' => 'fa-users'],
          ['title' => \Yii::t('app/trafficmanager', 'Nav Traffic'), 'url' => Url::toRoute('/trafficmanager/traffic'), 'icon' => 'fa-exchange'],
        ],
      ];
}

$sidebarWidget = [
  'title' => '',
  'icon' => 'fa-bars',
  'parts' => $parts,
  //'viewFilePath' => '@wajox/yii2base/themes/base/widgets/sidebarwidget/views/sidebar_widget.php',
];

$layoutOptions = [
  'sidebarWidgetOptions' => $sidebarWidget,
  'content' => $content,
];

echo $this->render('@app/views/shared/layouts/profile', $layoutOptions);
