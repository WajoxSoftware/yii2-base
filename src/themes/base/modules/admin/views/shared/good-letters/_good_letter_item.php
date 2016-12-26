<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodLetter-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-4">
      <?= $model->title ?>
    </div>

    <div class="col-md-3">
      <?= $model->letterType ?>
    </div>

    <div class="col-md-2">
      <?= $model->delayTime ?>
    </div>

    <div class="col-md-3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/good-letters/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-letters/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
