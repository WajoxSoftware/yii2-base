<?php
use yii\helpers\Url;

?>
<a data-user-id="<?=$model->id ?>" href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="row list-item">
  <div class="col m1">
    <?=$model->id ?>
  </div>

  <div class="col m3 col s6">
    <?=$model->email ?>
  </div>

  <div class="col m2 col s6">
    <?= $model->roleName ?>
  </div>

  <div class="col m3 col s6">
    <?= $model->name ?>
  </div>

  <div class="col m3 col s6">
    <?=$model->phone ?>
  </div>
</a>
