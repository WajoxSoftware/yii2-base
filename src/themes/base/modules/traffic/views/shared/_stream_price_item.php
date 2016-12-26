<?php
use yii\helpers\Url;

?>
<div class="list-item" data-TrafficStreamPrice-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-5">
      <?= $model->sum ?>P

      <?php if ($model->clicks_count > 0): ?>
        <span><i class="fa fa-mouse-pointer"></i><?= $model->clicks_count ?></span>
      <?php endif; ?>
    </div>
    <div class="col-md-3">
      <span class="text-muted">
        <?= $model->timeInterval ?>
      </span>
    </div>
    <div class="col-md-4">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/traffic/traffic-stream-prices/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/traffic/traffic-stream-prices/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
