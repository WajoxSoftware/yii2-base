<?php

use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Bills');
$this->params['breadcrumbs'][] = $this->title;

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'status'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '_bill_item',
  ]);
