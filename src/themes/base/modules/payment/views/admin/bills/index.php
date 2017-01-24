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
    'dataProvider' => $dataProvider,
    'itemView' => '_bill_item',
  ]);
