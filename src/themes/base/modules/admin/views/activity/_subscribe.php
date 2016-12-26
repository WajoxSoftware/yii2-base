<?php
use yii\helpers\Url;

?>

<div class="list-item" data-EmailList-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-3">
      <?php $url = Url::toRoute(['/subscribes/index', 'url' => $model->url]) ?>
      <a href="<?= $url ?>" target="_blank"><?= $model->url ?></a>
    </div>

    <div class="col-md-3">
      <?= $model->title ?>
    </div>

    <div class="col-md-6">
      <?= $model->description ?>
    </div>
  </div>
</div>
