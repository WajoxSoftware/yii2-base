<?php
use wajox\yii2base\models\EGoodEntity;

foreach (EGoodEntity::getTypeIdList() as $typeId => $typeName) {
    $this->params['pageControls']['items'][] = [
      'title' => $typeName,
      'url' => ['/admin/egood-entities/create', 'id' => $model->getModel()->id, 'typeId' => $typeId, 'suffix' => '.js'],
      'icon' => 'fa-plus',
      'class' => 'js-remote-link',
    ];
}

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/egood-entities/_egood_entity_item',
    'query' => $model->getModel()->getEntities(),
    'modelName' => 'EGoodEntity',
]);
