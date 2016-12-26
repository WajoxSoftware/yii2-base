<?php
echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'itemView' => '@app/modules/admin/views/shared/good-categories/_good_category_item',
    'dataProvider' => $dataProvider,
    'modelName' => 'GoodCategory',
]);
