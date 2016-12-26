<?php
$this->title = $model->title;

$viewsMap = [
    $model::TYPE_ID_CATALOG => 'catalog/_view',
    $model::TYPE_ID_PAGE =>  'page/_view',
];

$viewFile = '_view';

if (isset($viewMap[$model->type_id])) {
    $viewFile = $viewMap[$model->type_id];
}

echo $this->render($viewFile, [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]);
