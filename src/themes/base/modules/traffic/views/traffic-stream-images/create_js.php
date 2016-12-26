<?php $modal_content = rawurlencode($this->render('_modal', [
    'model' => $model,
    'stream' => $stream,
    'streamImage' => $streamImage,
    'modal_title' => \Yii::t('app', 'Add {model}', ['model' => \Yii::t('app/models', 'TrafficStreamImage')]),
])) ?>

<?php if ($success): ?>
  window.App.reload();
<?php else: ?>
  window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
