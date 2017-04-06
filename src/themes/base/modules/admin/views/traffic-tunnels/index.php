<?php
$this->title = \Yii::t('app/admin', 'Nav Traffic tunnels');
$this->params['breadcrumbs'][] = $this->title;
$this->params['pageControls']['items'][] = [

  'url' => [
    'create',
    'suffix' => '.js',
  ],
  'title' => \Yii::t('app/general', 'Add'),
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'itemView' => '@app/modules/admin/views/traffic-tunnels/_item',
  'query' => $query,
  'modelName' => 'TrafficTunnel',
]);
