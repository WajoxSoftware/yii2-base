<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodEmailList-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-4">
      <?= $model->emailList->title ?>
    </div>

    <div class="col-md-6">
      <?= $model->emailList->description ?>
    </div>

    <div class="col-md-2">
      <a href="<?= Url::toRoute(['/admin/good-email-lists/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
        <i class="fa fa-trash"></i>
        <?= \Yii::t('app', 'Delete') ?>
      </a>
    </div>
  </div>
</div>
