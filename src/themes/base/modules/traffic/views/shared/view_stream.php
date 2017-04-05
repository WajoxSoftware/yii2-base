<?php
use yii\helpers\Url;
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
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

?>

<h3><?= $stream->title ?></h3>
<p><?= $stream->getUrl() ?></p>
<div><p>Описание:</p><?= $stream->content ?></div>

<h3>Цена/Клики</h3>
<?= ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/traffic/views/shared/_stream_price_item',
]); ?>
