<?php
use yii\helpers\Url;

?>

<div class="list-item" data-TrafficTunnel-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-8">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </div>

    <div class="col-md-4">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
