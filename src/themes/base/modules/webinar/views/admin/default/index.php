<?php
$this->title = \Yii::t('app/admin', 'Nav Webinars');

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['create', 'suffix' => '.js'],
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/webinar/views/admin/default/_item',
    'dataProvider' => $dataProvider,
    'modelName' => 'Webinar',
]);
