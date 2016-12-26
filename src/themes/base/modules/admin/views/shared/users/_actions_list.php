<?php
use yii\widgets\ListView;

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/admin/views/shared/users/_user_action_log_item',
]);
