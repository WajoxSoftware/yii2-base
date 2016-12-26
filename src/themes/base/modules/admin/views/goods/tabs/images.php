<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/admin/good-images/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/good-images/_good_image_item',
    'query' => $model->getModel()->getImages(),
    'modelName' => 'GoodImage',
]);