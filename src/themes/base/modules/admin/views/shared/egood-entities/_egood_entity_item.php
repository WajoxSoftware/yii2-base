<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodCategory-id="<?= $model->id ?>">
  <div class="row">

    <div class="col-md-3"><?= $model->type ?></div>
    <div class="col-md-3"><?= $model->title ?></div>

    <div class="col-md-3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/egood-entities/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/egood-entities/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
