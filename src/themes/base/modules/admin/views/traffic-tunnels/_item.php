<?php
use yii\helpers\Url;

?>

<li class="collection-item" data-TrafficTunnel-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
    </span>
</li>

