<?php
use yii\widgets\ListView;
use wajox\yii2base\models\TrafficSource;

$this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-sources/create',
      'typeId' => TrafficSource::TYPE_ID_LINK,
      'id' => $user->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficSource'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/traffic/views/shared/_source_item',
]);
