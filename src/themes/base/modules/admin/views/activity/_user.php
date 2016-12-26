<?php
use yii\helpers\Url;

?>
<a data-User-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/users/view', 'id' => $model->id]) ?>" class="row list-item">
  <div class="col-md-1 hidden-xs hidden-sm">
    <?=$model->id ?>
  </div>
  <div class="col-md-3 col-xs-12 col-sm-6">
    <?=$model->email ?>
  </div>
  <div class="col-md-3 hidden-xs col-sm-6">
    <?= $model->name ?>
  </div>
  <div class="col-md-3 col-xs-12 col-sm-6">
    <?=$model->phone ?>
  </div>
  <div class="col-md-2 col-xs-12 col-sm-6">
    <?= $model->roleName ?>
  </div>
</a>
