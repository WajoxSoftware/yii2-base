<?php
echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
  'itemView' => '@app/modules/traffic/views/shared/_stream_image_item',
  'query' => $model->getImages(),
  'modelName' => 'TrafficStreamImage',
]);
