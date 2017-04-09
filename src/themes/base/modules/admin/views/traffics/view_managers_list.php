<?php
$this->title = \Yii::t('app/admin', 'Nav Traffics Managers');
$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/admin', 'Nav Traffics'),
  'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'url' => ['/admin/traffic-managers/create'],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'add',
];

echo $this->render('@app/modules/traffic/views/shared/view_managers_list', $_params_);
