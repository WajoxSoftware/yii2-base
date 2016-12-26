<?php
if (sizeof($models) > 0) {
    foreach ($models as $id => $model) {
        $result[] = [
            'id' => $id,
            'text' => $model->title,
            'title' => $model->title,
            'sum' => $model->sum,
            'url' => $model->url,
            'orderUrl' => $model->orderUrl,
        ];
    }
} else {
    $result = ['id' => '', 'text' => ''];
}

echo json_encode(['results' => $result]);
