<?php
use yii\helpers\Url;

?>
<a data-order-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/orders/view', 'id' => $model->id]) ?>" class="row message-item">
  <div class="col-sm-3">
    <?= $model->id ?>
  </div>
  <div class="col-sm-3">
    <?=$model->sum ?>
    <?php if ($model->delivery_sum > 0): ?>
    (+<?= $model->deliverySumRUR ?>)
    <?php endif; ?>
    P
  </div>
  <div class="col-sm-3">
    <?= $model->status ?>
  </div>

  <div class="col-sm-3">
    <?= $model->deliveryStatus ?>
  </div>
</a>
