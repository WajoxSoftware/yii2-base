<?php

$this->title = \Yii::t('app/admin', 'Nav Email Lists');
$this->params['breadcrumbs'][] = $this->title;
$this->render('@app/modules/admin/views/shared/mailing/_tabs', ['current' => 'email-lists']);
$this->params['pageControls']['items'][] = [
  'url' => ['create', 'suffix' => '.js'],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/subscribes/_email_list_item',
    'query' => $query,
    'modelName' => 'EmailList',
]);
