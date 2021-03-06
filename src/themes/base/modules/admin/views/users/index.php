<?php

$this->title = \Yii::t('app/admin', 'Nav Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['pageControls']['items'][] = [
  'url' => ['create'],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'add',
];

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'role', 'name', 'email', 'first_name',  'last_name', 'phone'],
  'body' => $this->render('_search', ['model' => $searchModel]),
];

$this->params['listingViewTypes'] = [
    'items' => ['table', 'list'],
    'current' => $listingViewType,
];

echo $this->render('_listing_' . $listingViewType, [
    'sort' => $sort,
    'dataProvider' => $dataProvider,
  ]);
