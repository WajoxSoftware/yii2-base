<?php
if (sizeof($models) > 0) {
    foreach ($models as $id => $model) {
        $result[] = [
            'id' => $id,
            'tag' => $model->tag,
            'name' => $model->name,
            'text' => $model->name,
        ];
    }
} else {
    $result = ['id' => '', 'text' => ''];
}

echo json_encode(['results' => $result]);
