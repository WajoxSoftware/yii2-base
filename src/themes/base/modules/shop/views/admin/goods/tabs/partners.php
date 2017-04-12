<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-partner-program-links/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/admin/views/admin/shared/good-partner-programs/_good_partner_program_link_item',
    'query' => $model->getModel()->goodPartner->getLinks(),
    'modelName' => 'GoodPartnerProgramLink',
]);
