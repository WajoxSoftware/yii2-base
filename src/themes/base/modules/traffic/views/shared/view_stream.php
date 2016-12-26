<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = $stream->title;

if ($source->hasParentSource) {
    $this->params['breadcrumbs'][] = [
      'label' => $source->parentSource->title,
      'url' => ['view-source', 'id' => $source->parent_source_id],
    ];
}

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
  'title' => \Yii::t('app', 'Add {model}', [
    'model' => \Yii::t('app/models', 'TrafficStreamPrice'),
  ]),
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];
$this->params['pageControls']['items'][] = [
  'url' => [
    '/traffic/traffic-stream-images/create',
    'id' => $stream->id,
    'suffix' => '.js',
  ],
  'title' => \Yii::t('app', 'Add {model}', [
    'model' => \Yii::t('app/models', 'TrafficStreamImage'),
  ]),
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];
?>

<?= $this->render('@app/modules/traffic/views/shared/_stream_images', ['model' => $stream]); ?>

<?= ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/traffic/views/shared/_stream_price_item',
]); ?>
