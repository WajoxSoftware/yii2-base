<?php
use yii\helpers\Url;

?>

<div class="list-item" data-GoodPartnerProgram-id="<?= $model->id ?>">
  <div class="row">
    <div class="col m4"><h6><?= \Yii::t('app/attributes', 'Good') ?>:</h6> <?= $model->goodTitle ?></div>
    <div class="col m4"><h6><?= \Yii::t('app/attributes', 'Partner') ?>:</h6> <?= $model->partnerFullName ?></div>
    <div class="col m2"><h6><?= \Yii::t('app/attributes', 'Fee 1 level') ?>:</h6> <?= $model->fee_1_level ?> P</div>
    <div class="col m2"><h6><?= \Yii::t('app/attributes', 'Fee 2 level') ?>:</h6> <?= $model->fee_2_level ?> P</div>
  </div>

  <div class="row">
    <div class="col m12">
      <h6><?= \Yii::t('app/attributes', 'Content') ?></h6>
      <?= $model->content ?>
    </div>
  </div>

  <div class="row">
    <div class="col m12">
      <h6>
        <?= \Yii::t('app/attributes', 'Links') ?>
        <a href="<?= Url::toRoute(['/admin/good-partner-program-links/create', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-plus"></i>
        </a>
      </h6>
    </div>
  </div>

  <div class="row">
    <div class="col m12">
      <?= \wajox\yii2widgets\crudwidget\ListWidget::widget([
          'itemView' => '@app/modules/admin/views/shared/good-partner-programs/_good_partner_program_link_item',
          'query' => $model->getLinks(),
          'modelName' => 'GoodPartnerProgramLink',
        ]); ?>
    </div>
  </div>

  <div class="row">
    <div class="col m12">
      <div class="btn-group" role="group">
        <a href="<?= Url::toRoute(['/admin/good-partner-programs/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-partner-programs/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
      </div>
    </div>
  </div>
</div>
