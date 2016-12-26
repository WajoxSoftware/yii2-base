<?php
use yii\helpers\Url;

?>

<div class="list-item list-item-dark" data-GoodPartnerProgramLink-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-3">
      <?= $model->url ?>
    </div>

    <div class="col-md-6">
      <?= $model->description ?>
    </div>

    <div class="col-md-3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/good-partner-program-links/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-partner-program-links/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
