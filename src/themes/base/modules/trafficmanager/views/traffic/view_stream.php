<?php
use yii\helpers\Url;

$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/trafficmanager', 'Nav Traffic'),
  'url' => ['index'],
];

echo $this->render('@app/modules/traffic/views/shared/view_stream', $_params_);
