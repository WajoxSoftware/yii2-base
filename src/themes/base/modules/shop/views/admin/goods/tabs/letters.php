<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-letters/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/shop/views/admin/shared/good-letters/_good_letter_item',
    'query' => $model->getModel()->getLetters(),
    'modelName' => 'GoodLetter',
]);
