<?php
use yii\helpers\Url;

?>
<div class="list-item" data-TrafficStream-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-12">
      <a href="<?= Url::toRoute(['view-stream', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </div>
  </div>

  <div class="row text-muted  hidden-sm hidden-xs">
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream Subscribes') ?></div>
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream Clicks') ?></div>
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream Orders') ?></div>
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream eCPC') ?></div>
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream CPC') ?></div>
    <div class="col-md-2"><?= \Yii::t('app/attributes', 'Traffic Stream ROI') ?></div>
  </div>

  <div class="row hidden-sm hidden-xs">
    <div class="col-md-2">
      <span data-role="stat" data-target="subscribes_count">0</span>
    </div>
    <div class="col-md-2">
      <span data-role="stat" data-target="clicks_count">0</span>
    </div>
    <div class="col-md-2">
      <span data-role="stat" data-target="bill_sum">0.00</span>
    </div>
    <div class="col-md-2">
      <span data-role="stat" data-target="ecpc">0.00</span>
    </div>
    <div class="col-md-2">
      <span data-role="stat" data-target="cpc">0.00</span>
    </div>
    <div class="col-md-2">
      <span data-role="stat" data-target="roi">0</span> %
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="btn-group" role="group">
        <a href="#" class="btn btn-xs btn-default" data-subaccount-link-generator="true" data-link-template="<?= $model->getUrl('[subaccount_tag]') ?>">
            <i class="fa fa-link"></i>
            <?= \Yii::t('app', 'Generate link') ?>
        </a>
        <a href="<?= Url::toRoute(['/traffic/traffic-streams/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"><?= \Yii::t('app', 'Edit') ?></i>
        </a>
        <a href="<?= Url::toRoute(['/traffic/traffic-streams/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"><?= \Yii::t('app', 'Delete') ?></i>
        </a>
      </div>
    </div>
  </div>
</div>
