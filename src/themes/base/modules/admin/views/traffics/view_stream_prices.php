<?php
$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/admin', 'Nav Traffics'),
  'url' => ['index'],
];

$this->params['breadcrumbs'][] = [
  'label' => $user->name,
  'url' => ['view-user', 'id' => $user->id],
];

echo $this->render('@app/modules/traffic/views/shared/view_stream_prices', $_params_);
