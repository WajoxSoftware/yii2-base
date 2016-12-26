<?php
use yii\helpers\Url;

$this->title = $user->name;

$this->params['breadcrumbs'][] = [
  'label' => \Yii::t('app/admin', 'Nav Traffics'),
  'url' => ['index'],
];

$this->params['breadcrumbs'][] = $this->title;

echo $this->render('@app/modules/traffic/views/shared/view_user', $_params_);
