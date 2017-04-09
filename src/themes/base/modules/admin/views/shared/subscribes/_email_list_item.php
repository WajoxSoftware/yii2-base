<?php
use yii\helpers\Url;

?>

<div class="list-item" data-EmailList-id="<?= $model->id ?>">
  <div class="row">
    <div class="col m3">
      <a href="<?= $model->subscribeUrl ?>" target="_blank"><?= $model->url ?></a>
    </div>

    <div class="col m3">
      <?= $model->title ?>
    </div>

    <div class="col m3">
      <?= $model->description ?>
    </div>

    <div class="col m3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/email-lists/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/email-lists/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
