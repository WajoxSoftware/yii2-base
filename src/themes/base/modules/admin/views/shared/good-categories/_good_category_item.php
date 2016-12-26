<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodCategory-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-3">
      <a href="<?= Url::toRoute(['/admin/goods/index', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </div>
    <div class="col-md-3"><?= $model->url ?></div>
    <div class="col-md-3"><?= $model->status ?></div>

    <div class="col-md-3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/good-categories/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-categories/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
