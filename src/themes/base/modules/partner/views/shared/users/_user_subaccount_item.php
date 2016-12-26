<?php
use yii\helpers\Url;

?>

<div class="list-item" data-UserSubaccount-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-4">
      <?= $model->name ?>
    </div>

    <div class="col-md-4">
      <?= $model->tag ?>
    </div>

    <div class="col-md-4">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/partner/user-subaccounts/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/partner/user-subaccounts/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
