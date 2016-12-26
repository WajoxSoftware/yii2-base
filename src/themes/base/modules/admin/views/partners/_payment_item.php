<?php

?>
<div  class="row message-item">
  <div class="col-sm-2">
    <?= $model->id ?>
  </div>
  <div class="col-sm-3">
    <?=$model->sumRUR ?>
    P
  </div>

  <div class="col-sm-3">
    <?=$model->paymentDestination ?>
  </div>

  <div class="col-sm-2">
    <?= $model->createdDateTime ?>
  </div>

  <div class="col-md-2">
    <?php if ($model->isPartnerFee): ?>
      <a href="wmk:payto?Purse=<?= $model->user->partner->webmoney_rub ?>&Amount=<?=$model->sumRUR ?>&Desc=Payment<?= $model->id ?>&BringToFront=Y" class="btn btn-xs btn-default js-remote-link">
        <?= \Yii::t('app', 'Give To WMKeeper') ?>
      </a>
    <?php endif; ?>
  </div>
</div>
