<?php
use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@app/modules/traffic/views/shared/_manager_item',
  ]);
