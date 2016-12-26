<?= json_encode([
    'errors' => $model->errors,
    'status' => $model->isNewRecord ? 'failed' : 'ok',
]);