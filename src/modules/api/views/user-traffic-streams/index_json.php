<?php
if (sizeof($models) > 0) {
    foreach ($models as $id => $model) {
        $result[] = [
            'id' => $id,
            'title' => $model->title,
            'text' => $model->title,
        ];
    }
} else {
    $result = ['id' => '', 'text' => ''];
}

echo json_encode(['results' => $result]);
