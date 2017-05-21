<?= \json_encode([
    'viewersCount' => $viewersCount,
    'viewers' => array_map(
        function ($webinarViewer) {
            return $webinarViewer->name;
        },
        $viewers
    ),
    'enableAdvert' => $model->isAdvertEnabled,
]);
