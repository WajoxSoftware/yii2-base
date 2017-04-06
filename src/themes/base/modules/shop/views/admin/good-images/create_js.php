<?php $modal_content = rawurlencode($this->render('_modal', [
    'model' => $model,
    'good' => $good,
    'goodImage' => $goodImage,
    'modal_title' => \Yii::t('app/general', 'Add {model}', ['model' => \Yii::t('app/models', 'GoodImage')]),
])) ?>

<?php if ($success): ?>
    window.App.reload();
    window.App.hideModal(decodeURIComponent('<?= $modal_content ?>'));
<?php else: ?>
    window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
