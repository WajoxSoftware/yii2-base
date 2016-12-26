<?php
use yii\helpers\Url;
?>

<a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="row list-item">
  <div class="col-md-2">
    <?= $model->status ?>
  </div>

  <div class="col-md-4">
    <?= $model->subject ?>
  </div>

  <div class="col-md-4">
    <p class="text-muted"><?= $model->shortMessage ?></p>
  </div>

  <div class="col-md-2">
    <?= $model->createdDateTime ?>
  </div>
</div>
