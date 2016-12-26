<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodImage-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-2">
      <img src="<?= $model->previewUrl ?>"/>
    </div>
    <div class="col-md-8">
      <a href="<?= $model->url ?>" target="_blank"><?= $model->url ?></a>
    </div>
    <div class="col-md-2">
      <a href="<?= Url::toRoute(['/admin/good-images/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
        <i class="fa fa-trash"></i>
        <?= \Yii::t('app/general', 'Delete') ?>
      </a>
    </div>
  </div>
</div>
