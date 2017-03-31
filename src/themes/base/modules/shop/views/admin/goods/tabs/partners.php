<?php
$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Add'),
  'url' => ['/shop/admin/good-partner-program-links/create', 'id' => $model->getModel()->id, 'suffix' => '.js'],
  'icon' => 'fa-plus',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/good-partner-programs/_good_partner_program_link_item',
    'query' => $model->getModel()->partnerProgram->getLinks(),
    'modelName' => 'GoodPartnerProgramLink',
]);
