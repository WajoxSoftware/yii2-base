<?php
$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => $source->title,
  'url' => ['view-source', 'id' => $source->id],
];

$this->params['breadcrumbs'][] = $this->title;

$this->render('@app/modules/traffic/views/shared/_stream_tabs', [
  'current' => 'index',
  'model' => $stream,
]);
?>

<p><?= \Yii::t('app/general', 'Title') ?>: <?= $stream->title ?></p>
<p><?= \Yii::t('app/general', 'Link') ?>: <?= $stream->getUrl() ?></p>
<div>
  <p><?= \Yii::t('app/general', 'Description') ?>:</p>
  <p><?= $stream->content ?></p>
</div>
