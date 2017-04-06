<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Customers');
$this->params['breadcrumbs'][] = $this->title;

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'email', 'full_name', 'phone'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
]);
