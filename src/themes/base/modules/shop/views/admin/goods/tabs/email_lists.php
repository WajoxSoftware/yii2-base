<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-email-lists/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/admin/views/shared/good-email-lists/_good_email_list_item',
    'query' => $model->getModel()->getGoodEmailLists(),
    'modelName' => 'GoodEmailList',
]);
