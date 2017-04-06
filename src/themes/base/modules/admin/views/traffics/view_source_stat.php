<?php
$this->title = $source->title;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/admin', 'Nav Traffics'),
  'url' => ['index'],
];

$this->params['breadcrumbs'][] = [
  'label' => $user->name,
  'url' => ['view-user', 'id' => $user->id],
];

echo $this->render('@app/modules/traffic/views/shared/view_source_stat', $_params_);
