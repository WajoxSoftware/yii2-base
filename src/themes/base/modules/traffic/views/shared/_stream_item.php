<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-TrafficStream-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view-stream', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <p><?= $model->createdDateTime ?>, <?= $model->status ?></p>
    <p><?= $model->shortMessage ?></p>

    <span class="secondary-content">
          <a href="#" data-subaccount-link-generator="true" data-link-template="<?= $model->getUrl('[subaccount_tag]') ?>">
              <i class="fa fa-link"></i>
              <?= \Yii::t('app/general', 'Generate link') ?>
          </a>

          <a href="<?= Url::to(['/traffic/traffic-stream-prices/create', 'id' => $model->id, 'suffix' => '.js']) ?>"  class="js-remote-link"><i class="fa fa-plus"></i><?= \Yii::t('app/trafficmanager', 'Price/Clicks') ?></a>

          <?php if ($model->level < 5): ?>
            <a href="<?= Url::toRoute(['/traffic/traffic-streams/create', 'sourceId' => $model->traffic_source_id, 'streamId' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
              <i class="fa fa-plus"><?= \Yii::t('app/general', 'Add') ?></i>
            </a>
          <?php endif; ?>

          <a href="<?= Url::toRoute(['/traffic/traffic-streams/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
            <i class="fa fa-pencil"><?= \Yii::t('app/general', 'Edit') ?></i>
          </a>

          <a href="<?= Url::toRoute(['/traffic/traffic-streams/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
            <i class="fa fa-trash"><?= \Yii::t('app/general', 'Archivate') ?></i>
          </a>
    </span>
</li>
