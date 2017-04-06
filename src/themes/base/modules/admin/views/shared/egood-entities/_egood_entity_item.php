<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-GoodCategory-id="<?= $model->id ?>">
    <span class="title">
      <?= $model->title ?>
    </span>

    <p><?= $model->type ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/admin/egood-entities/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/egood-entities/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
    </span>
</li>

