<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodUserCoupon-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-3"><?= $model->partnerFullName ?></div>
    <div class="col-md-3"><?= $model->sumRUR ?> P</div>
    <div class="col-md-3"><?= $model->dueDate ?></div>

    <div class="col-md-3">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/good-user-coupons/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-user-coupons/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
