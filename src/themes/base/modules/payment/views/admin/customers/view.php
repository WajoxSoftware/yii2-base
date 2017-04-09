<?php
use yii\helpers\Url;

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Edit'),
  'url' => ['update', 'id' => $model->id, 'suffix' => '.js'],
  'icon' => 'edit',
  'class' => 'js-remote-link',
];

echo $this->render('@app/modules/admin/views/shared/customers/_customer_card', ['model' => $model]);

echo $this->render('@app/modules/admin/views/shared/users/_actions_list', ['dataProvider' => $dataProvider]);
