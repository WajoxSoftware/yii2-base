<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $source->title;

$this->render('@app/modules/traffic/views/shared/_source_tabs', [
  'current' => 'stat',
  'model' => $source,
]);

$this->params['filter'] = [
    'model' => $searchModel,
    'items' => ['datesInterval'],
    'body' => $this->render('@app/modules/traffic/views/shared/_source_stat_search_form', ['model' => $searchModel]),
];


echo $this->render(
  '@app/modules/traffic/views/shared/_source_streams_stat',
  [
    'searchModel' => $searchModel,
    'streams' => $streams,
  ]
);
