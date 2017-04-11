<?php
use wajox\yii2base\modules\shop\models\EGoodEntity;

foreach (EGoodEntity::getTypeIdList() as $typeId => $typeName) {
    $this->params['pageControls']['items'][] = [
      'title' => $typeName,
      'url' => ['/shop/admin/egood-entities/create', 'id' => $model->getModel()->id, 'typeId' => $typeId, 'suffix' => '.js'],
      'icon' => 'add',
      'class' => 'js-remote-link',
    ];
}

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/shop/views/admin/shared/egood-entities/_egood_entity_item',
    'query' => $model->getModel()->getEntities(),
    'modelName' => 'EGoodEntity',
]);
