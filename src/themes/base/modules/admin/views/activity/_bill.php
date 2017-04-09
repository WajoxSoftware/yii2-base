<?php
use yii\helpers\Url;

?>

<a data-Bill-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/bills/view', 'id' => $model->id]) ?>" class="row bill-item bill-status-<?=$model->status_id ?>">
  <div class="col m2status">
    <?=$model->status ?>
  </div>
  <div class="col m2 s2 sum">
    <?=$model->sumRUR ?> P
  </div>
  <div class="col m3 s4">
    <?= $model->customer->email ?>
  </div>
  <div class="col m3 s4 destination">
    <?=$model->paymentDestination ?>
  </div>
  <div class="col m2 s4 date">
    <?= $model->statusDate ?>
  </div>
</a>
