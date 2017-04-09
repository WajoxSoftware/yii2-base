<?php
use yii\helpers\Url;

?>
<a data-Partner-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/partners/view', 'id' => $model->id]) ?>" class="row list-item message-item">
  <div class="col s3">
    <?=$model->user->name ?>
  </div>

  <div class="col s3">
    <?= $model->user->accountBalanceRUR ?> P
  </div>

  <div class="col s3">
    <?= $model->webmoney_rub ?>,
  </div>

  <div class="col s3">
    <?=$model->partnerType ?>
  </div>
</a>
