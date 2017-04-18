<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'index']);
$this->params['pageControls']['items'][] = [
  'url' => ['create'],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'add',
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
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_partner_item',
]);
