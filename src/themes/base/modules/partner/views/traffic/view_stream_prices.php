<?php
use yii\helpers\Url;

$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/partner', 'Nav Traffic'),
  'url' => ['index'],
];

echo $this->render('@app/modules/traffic/views/shared/view_stream_prices', $_params_);
