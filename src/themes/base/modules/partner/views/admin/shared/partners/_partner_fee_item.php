<?php
use yii\helpers\Url;

?>
<li  class="collection-item" data-PartnerFee-id="<?= $model->id ?>">
  <span class="title">
    <?= $model->createdDateTime ?>, <?=$model->sumRUR ?> P
  </spun>

  <p>
    <?php $order_url = Url::toRoute(['/admin/orders/view', 'id' => $model->order_id]); ?>
    <a href="<?= $order_url ?>"><?= \Yii::t('app/models', 'Order') ?> #<?= $model->order_id ?></a>
  </p>

  <p><?=$model->status ?></p>

  <span class="secondary-content">
        <?php if ($model->isNew || $model->isCancelled): ?>
          <a href="<?= Url::toRoute(['/admin/partner-fees/confirm', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
            <i class="material-icons">check</i>
          </a>
        <?php endif; ?>

        <?php if ($model->isNew): ?>
          <a href="<?= Url::toRoute(['/admin/partner-fees/cancel', 'id' => $model->id, 'suffix' => '.js']) ?>"  class="js-remote-link">
            <i class="material-icons">cancel</i>
          </a>
        <?php endif; ?>
  </span>
</li>
