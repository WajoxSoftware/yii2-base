<?php
use yii\helpers\Url;

?>
<li class="collection-item avatar" data-TrafficStreamPrice-id="<?= $model->id ?>">
    <i class="material-icons circle">attach_money</i>
    <span class="title">
      <?= $model->timeInterval ?> (<?= $model->sum ?>P)
    </span>

    <?php if ($model->clicks_count > 0): ?>
      <p><i class="fa fa-mouse-pointer"></i><?= $model->clicks_count ?></p>
    <?php endif; ?>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/traffic/traffic-stream-prices/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/traffic/traffic-stream-prices/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
    </span>
</li>

