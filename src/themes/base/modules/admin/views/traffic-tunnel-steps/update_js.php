<?php $modal_content = rawurlencode($this->render('_modal', [
    'model' => $model,
    'modal_title' => \Yii::t('app/general', 'Update {model}', ['model' => \Yii::t('app/models', 'TrafficTunnel')]),
])) ?>

<?php if ($success): ?>
  window.App.reload();
<?php else: ?>
  window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
