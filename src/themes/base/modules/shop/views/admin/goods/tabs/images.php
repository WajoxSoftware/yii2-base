<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-images/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/shop/views/admin/shared/good-images/_good_image_item',
    'query' => $model->getModel()->getImages(),
    'modelName' => 'GoodImage',
]);
