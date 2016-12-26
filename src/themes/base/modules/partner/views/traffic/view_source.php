<?php
use yii\helpers\Url;

$this->title = $source->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/partner', 'Nav Traffic'),
  'url' => ['index'],
];

echo $this->render('@app/modules/traffic/views/shared/view_source', $_params_);
