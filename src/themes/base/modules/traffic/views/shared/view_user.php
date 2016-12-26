<?php
use yii\widgets\ListView;

$this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-sources/create',
      'id' => $user->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficSource'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/traffic/views/shared/_source_item',
]);
