<?php
  use yii\helpers\Url;

$modal_content = rawurlencode($this->render('_modal', [
    'model' => $model,
    'model_user' => $model_user,
    'modal_title' => \Yii::t('app', 'Add'),
])) ?>

<?php if ($success): ?>
  window.App.redirect('<?= Url::toRoute(['/admin/partners/payments', 'id' => $model_user->partner->id]) ?>');
<?php else: ?>
  window.App.showModal(decodeURIComponent('<?= $modal_content ?>'));
<?php endif; ?>
