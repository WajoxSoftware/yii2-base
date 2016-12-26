<?php
if (sizeof($models) > 0) {
    foreach ($models as $id => $model) {
        $result[] = [
            'id' => $id,
            'name' => $model->name,
            'email' => $model->email,
            'fullName' => $model->fullName,
            'text' => $model->name,
        ];
    }
} else {
    $result = ['id' => '', 'text' => ''];
}

echo json_encode(['results' => $result]);
