<?= json_encode([
    'model' => $model->toArray(),
    'errors' => $model->errors,
    'status' => $model->isNewRecord ? 'failed' : 'ok',
]);
