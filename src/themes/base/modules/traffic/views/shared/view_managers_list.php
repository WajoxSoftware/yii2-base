<?php
use yii\widgets\ListView;

echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '@app/modules/traffic/views/shared/_manager_item',
  ]);
