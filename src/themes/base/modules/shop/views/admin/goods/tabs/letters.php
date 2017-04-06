<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-letters/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/good-letters/_good_letter_item',
    'query' => $model->getModel()->getLetters(),
    'modelName' => 'GoodLetter',
]);
