<?php
use yii\helpers\Url;

$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/admin', 'Nav Traffics'),
  'url' => ['index'],
];

$this->params['breadcrumbs'][] = [
  'label' => $user->name,
  'url' => ['view-user', 'id' => $user->id],
];

echo $this->render('@app/modules/traffic/views/shared/view_stream', $_params_);
