<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Orders');
$this->params['breadcrumbs'][] = $this->title;

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'bill_id', 'status', 'deliveryStatus'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

$this->params['sort'] = [
    'items' => [
        'id',
        'status_id',
        'delivery_status_id',
        'sum',
        'status_at',
        'created_at',
    ],
    'sort' => $sort,
];

echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
]);
