<?php
use yii\helpers\Url;

?>
<div  class="row list-item message-item" data-PartnerFee-id="<?= $model->id ?>">
  <div class="col-md-2">
    <?= $model->createdDateTime ?>
  </div>

  <div class="col-md-2">
    <?=$model->sumRUR ?> P
  </div>

  <div class="col-md-3">
    <?php $order_url = Url::toRoute(['/admin/orders/view', 'id' => $model->order_id]); ?>
    <a href="<?= $order_url ?>"><?= \Yii::t('app/models', 'Order') ?> #<?= $model->order_id ?></a>
  </div>

  <div class="col-md-2">

      <?=$model->status ?>
  </div>

  <div class="col-md-3">
      <div class="btn-group" role="group">
        <?php if ($model->isNew || $model->isCancelled): ?>
          <a href="<?= Url::toRoute(['/admin/partner-fees/confirm', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
            <?= \Yii::t('app/general', 'Confirm') ?>
          </a>
        <?php endif; ?>

        <?php if ($model->isNew): ?>
          <a href="<?= Url::toRoute(['/admin/partner-fees/cancel', 'id' => $model->id, 'suffix' => '.js']) ?>"  class="btn btn-xs btn-default js-remote-link">
            <?= \Yii::t('app/general', 'Cancel') ?>
          </a>
        <?php endif; ?>
      </div>
  </div>
</div>
