<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/admin/good-email-lists/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/good-email-lists/_good_email_list_item',
    'query' => $model->getModel()->getGoodEmailLists(),
    'modelName' => 'GoodEmailList',
]);
