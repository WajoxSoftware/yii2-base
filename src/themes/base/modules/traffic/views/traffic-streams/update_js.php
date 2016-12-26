<?php $modal_content = rawurlencode($this->render('_modal', [
    'builder' => $builder,
    'modal_title' => \Yii::t('app/general', 'Update {model}', ['model' => \Yii::t('app/models', 'TrafficStream')]),
])) ?>

<?php if ($success): ?>
  window.App.reload();
<?php else: ?>
  window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
