<?php
use yii\widgets\ListView;

echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/admin/views/shared/users/_user_action_log_item',
]);
