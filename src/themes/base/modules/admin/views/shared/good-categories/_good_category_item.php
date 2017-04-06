<?php
use yii\helpers\Url;

?>

<li class="collection-item" data-GoodCategory-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['/admin/goods/index', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <p><?= $model->url ?><</p>
    <p><?= $model->status ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/admin/good-categories/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-categories/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
    </span>
</li>

