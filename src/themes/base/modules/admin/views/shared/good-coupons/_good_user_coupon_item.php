<?php
use yii\helpers\Url;

?>
<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-GoodUserCoupon-id="<?= $model->id ?>">
    <span class="title">
      <?= $model->partnerFullName ?>
    </span>

    <p><?= $model->dueDate ?>, <?= $model->sumRUR ?> P</p>
    <p><?= $model->shortMessage ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/admin/good-user-coupons/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-pencil"></i>
          <?= \Yii::t('app/general', 'Edit') ?>
        </a>

        <a href="<?= Url::toRoute(['/admin/good-user-coupons/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="fa fa-trash"></i>
          <?= \Yii::t('app/general', 'Delete') ?>
        </a>
    </span>
</li>

