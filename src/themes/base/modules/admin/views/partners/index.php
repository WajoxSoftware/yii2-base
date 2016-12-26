<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'index']);
$this->params['pageControls']['items'][] = [
  'url' => ['create'],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'fa-plus',
];

$this->params['sort'] = [
    'items' => [
        'id',
        'parent_partner_id',
        'subscribers_count',
        'subscribes_count',
        'sales_count',
        'clicks_count',
        'sales_sum',
        'payments_sum',
        'url',
        'city',
        'created_at',
    ],
    'sort' => $sort,
];

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_partner_item',
]);
