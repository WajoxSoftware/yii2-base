<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodPartnerProgramLink-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-6">
      <?= $model->description ?>
    </div>

    <div class="col-md-6">
      <input type="text" value="<?= $model->url ?>" class="form-control"/>
    </div>
  </div>
</div>
