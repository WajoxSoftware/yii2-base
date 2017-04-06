<?php
use yii\widgets\ListView;

$this->params['sort'] = [
    'items' => [
        'id',
        'name',
        'email',
        'first_name',
        'last_name',
        'created_at',
    ],
    'sort' => $sort,
];

echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '_user_item',
]);
