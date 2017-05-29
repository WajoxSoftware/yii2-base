<?= \json_encode([
    'viewersCount' => $viewersCount,
    'viewers' => array_map(
        function ($webinarViewer) {
            return $webinarViewer->name;
        },
        $viewers
    ),
    'enableAdvert' => $model->isAdvertEnabled,
    'isActive' => $model->isActive,
    'isFinished' => $model->isFinished,
    'isStarted' => $model->isStarted,
    'duration' => $model->duration,
    'currentTime' => $model->currentTime,
]);
