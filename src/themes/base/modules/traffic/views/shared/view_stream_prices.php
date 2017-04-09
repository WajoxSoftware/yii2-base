<?php
use yii\widgets\ListView;

$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => $source->title,
  'url' => ['view-source', 'id' => $source->id],
];

$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'url' => [
    '/traffic/traffic-stream-prices/create',
    'id' => $stream->id,
    'suffix' => '.js',
  ],
  'title' => \Yii::t('app/general', 'Add {model}', [
    'model' => \Yii::t('app/models', 'TrafficStreamPrice'),
  ]),
  'icon' => 'add',
  'class' => 'js-remote-link',
];

$this->render('@app/modules/traffic/views/shared/_stream_tabs', [
  'current' => 'prices',
  'model' => $stream,
]);

echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/traffic/views/shared/_stream_price_item',
]);
