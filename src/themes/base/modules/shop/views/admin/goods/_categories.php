<?php
echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/admin/views/shared/good-categories/_good_category_item',
    'dataProvider' => $dataProvider,
    'modelName' => 'GoodCategory',
]);
