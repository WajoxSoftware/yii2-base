<?php
use yii\helpers\Url;
?>

<a data-Bill-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/bills/view', 'id' => $model->id]) ?>" class="row bill-item bill-status-<?=$model->status_id ?>">
  <div class="col-md-2 hidden-xs col-sm-2 status">
    <?=$model->status ?>
  </div>
  <div class="col-md-2 col-xs-3 col-sm-2 sum">
    <?=$model->sumRUR ?> P
  </div>
  <div class="col-md-3 col-xs-5 col-sm-4">
    <?= $model->customer->email ?>
  </div>
  <div class="col-md-3 col-xs-5 col-sm-4 destination">
    <?=$model->paymentDestination ?>
  </div>
  <div class="col-md-2 col-xs-4 col-sm-4 date">
    <?= $model->statusDate ?>
  </div>
</a>
