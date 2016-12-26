<?php $modal_content = rawurlencode($this->render('_modal', [
    'model' => $model,
    'modal_title' => \Yii::t('app', 'Add {model}', ['model' => \Yii::t('app/models', 'UserSubaccount')]),
])) ?>

<?php if ($success): ?>
    window.App.reload();
    window.App.hideModal(decodeURIComponent('<?= $modal_content ?>'));
<?php else: ?>
    window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
