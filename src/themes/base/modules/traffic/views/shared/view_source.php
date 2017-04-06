<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $source->title;

$this->render('@app/modules/traffic/views/shared/_source_tabs', [
  'current' => 'index',
  'model' => $source,
]);

$this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-streams/create',
      'sourceId' => $source->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficStream'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

echo $this->render(
  '@app/modules/traffic/views/shared/_source_streams',
  [
    'searchModel' => $searchModel,
    'streams' => $streams,
  ]
);
