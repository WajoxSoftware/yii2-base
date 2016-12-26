<?php
use yii\helpers\Url;

?>
<a data-Partner-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/partners/view', 'id' => $model->id]) ?>" class="row list-item message-item">
  <div class="col-sm-3 col-xs-12">
    <?=$model->user->name ?>
  </div>

  <div class="col-sm-3 hidden-xs">
    <?= $model->user->accountBalanceRUR ?> P
  </div>

  <div class="col-sm-3 hidden-xs">
    <?= $model->webmoney_rub ?>,
  </div>

  <div class="col-sm-3 hidden-xs">
    <?=$model->partnerType ?>
  </div>
</a>
