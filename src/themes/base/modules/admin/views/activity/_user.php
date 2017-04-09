<?php
use yii\helpers\Url;

?>
<a data-User-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/users/view', 'id' => $model->id]) ?>" class="row list-item">
  <div class="col m1">
    <?=$model->id ?>
  </div>
  <div class="col m3 s6">
    <?=$model->email ?>
  </div>
  <div class="col m3 s6">
    <?= $model->name ?>
  </div>
  <div class="col m3 s6">
    <?=$model->phone ?>
  </div>
  <div class="col m2 s6">
    <?= $model->roleName ?>
  </div>
</a>
