<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/trafficmanager', 'Nav Subaccounts');
$this->params['breadcrumbs'][] = $this->title;
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/trafficmanager/user-subaccounts/create', 'suffix' => '.js'],
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
  'itemView' => '@app/modules/trafficmanager/views/shared/users/_user_subaccount_item',
  'query' => $model->getSubaccounts(),
  'modelName' => 'UserSubaccount',
]);
