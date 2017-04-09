<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/account', 'Account Settings');
$this->params['breadcrumbs'][] = $this->title;

$this->render('@app/modules/account/views/shared/_tabs', ['current' => 'settings']);

?>
<div class="row">
  <div class="col m3">
    <?= $this->render('_avatar_form', [
        'model' => $modelAvatar,
        'modelUser' => $modelUser,
      ]) ?>
  </div>
  <div class="col m9">
    <?php if (!$modelUser->isConfirmed()): ?>
        <div class="form-group-addon">
            <a href="<?= Url::toRoute(['/account/settings/resend-confirmation']) ?>"  class="btn btn-warning btn-xs">
               <?= \Yii::t('app/general', 'Confirm') ?>
            </a>
        </div>
    <?php endif; ?>

    <?= $this->render('_user_form', ['model' => $modelUser]) ?>
  </div>
</div>
