<?php

?>
<div  class="row list-item message-item" data-PartnerFee-id="<?= $model->id ?>">
  <div class="col-md-2">
    <?= $model->createdAt ?>
  </div>

  <div class="col-md-2">
    <?=$model->sumRUR ?>
    P
  </div>

  <div class="col-md-3">
    <?= \Yii::t('app/models', 'Order') ?> #<?= $model->order_id ?>
  </div>

  <div class="col-md-5">
      <?=$model->status ?>
  </div>
</div>
