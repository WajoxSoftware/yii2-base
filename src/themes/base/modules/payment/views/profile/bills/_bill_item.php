<?php
use yii\helpers\Url;

?>
<a data-bill-id="<?=$model->id ?>" href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="row bill-item bill-status-<?=$model->status ?>">
  <div class="col-md-2 hidden-xs col-sm-2 status">
    <?=$model->status ?>
  </div>
  <div class="col-md-2 col-xs-3 col-sm-2 sum">
    <?=$model->sumRUR ?> P
  </div>
  <div class="col-md-6 col-xs-5 col-sm-4 destination">
    <?=$model->paymentDestination ?>
  </div>
  <div class="col-md-2 col-xs-4 col-sm-4 date">
    <?= $model->statusDate ?>
  </div>
</a>
