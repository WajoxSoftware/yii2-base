<?php
use yii\helpers\Url;

?>
<a data-Customer-id="<?=$model->id ?>" href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="row list-item">
  <div class="col-md-1 hidden-xs col-sm-2 status">
    <?=$model->status ?>
  </div>
  <div class="col-md-3 col-xs-3 col-sm-2 sum">
    <?=$model->email ?>
  </div>
  <div class="col-md-3 col-xs-5 col-sm-4">
    <?= $model->fullName ?>
  </div>
  <div class="col-md-3 col-xs-5 col-sm-4 destination">
    <?=$model->phone ?>
  </div>
  <div class="col-md-2 col-xs-4 col-sm-4 date">
    <?= $model->fullAddress ?>
  </div>
</a>
