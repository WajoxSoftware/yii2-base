<?php
use yii\helpers\Url;

?>
<div class="list-item" data-TrafficStream-id="<?= $model->id ?>">
  <div class="row">
    <div class="col-md-4">
      <div class="traffic-stream-level-<?= $model->level ?>">
        <a href="<?= Url::toRoute(['view-stream', 'id' => $model->id]) ?>"><?= $model->title ?></a>
      </div>
    </div>

    <div class="col-md-8">
      <?php if ($stat): ?>
        <table class="table table-striped">
          <tr>
            <td>
              <span data-role="stat" data-target="subscribes_count">0</span>
            </td>
            <td>
              <span data-role="stat" data-target="clicks_count">0</span>
            </td>
            <td>
              <span data-role="stat" data-target="bill_sum">0.00</span>
            </td>
            <td>
              <span data-role="stat" data-target="ecpc">0.00</span>
            </td>
            <td>
              <span data-role="stat" data-target="cpc">0.00</span>
            </td>
            <td>
              <span data-role="stat" data-target="roi">0</span> %
            </td>
          </tr>
        </table>
      <?php else: ?>
        <div class="btn-group" role="group">
          <a href="#" class="btn btn-xs btn-default" data-subaccount-link-generator="true" data-link-template="<?= $model->getUrl('[subaccount_tag]') ?>">
              <i class="fa fa-link"></i>
              <?= \Yii::t('app/general', 'Generate link') ?>
          </a>

          <a href="<?= Url::to(['/traffic/traffic-stream-prices/create', 'id' => $model->id, 'suffix' => '.js']) ?>"  class="btn btn-xs btn-default js-remote-link"><i class="fa fa-plus"></i><?= \Yii::t('app/trafficmanager', 'Price/Clicks') ?></a>

          <?php if ($model->level < 5): ?>
            <a href="<?= Url::toRoute(['/traffic/traffic-streams/create', 'sourceId' => $model->traffic_source_id, 'streamId' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
              <i class="fa fa-plus"><?= \Yii::t('app/general', 'Add') ?></i>
            </a>
          <?php endif; ?>

          <a href="<?= Url::toRoute(['/traffic/traffic-streams/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
            <i class="fa fa-pencil"><?= \Yii::t('app/general', 'Edit') ?></i>
          </a>

          <a href="<?= Url::toRoute(['/traffic/traffic-streams/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
            <i class="fa fa-trash"><?= \Yii::t('app/general', 'Delete') ?></i>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
