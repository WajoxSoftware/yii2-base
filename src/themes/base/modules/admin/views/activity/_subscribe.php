<?php
use yii\helpers\Url;

?>

<div class="list-item" data-EmailList-id="<?= $model->id ?>">
  <div class="row">
    <div class="col m3">
      <?php $url = Url::toRoute(['/subscribes/index', 'url' => $model->url]) ?>
      <a href="<?= $url ?>" target="_blank"><?= $model->url ?></a>
    </div>

    <div class="col m3">
      <?= $model->title ?>
    </div>
  </div>
</div>
