<li class="collection-item" data-PartnerFee-id="<?= $model->id ?>">
    <span class="title">
      <?= $model->createdAt ?>
      (<?= \Yii::t('app/models', 'Order') ?> #<?= $model->order_id ?>)
    </span>

    <p><?=$model->sumRUR ?>P, <?=$model->status ?></p>


    <span class="secondary-content">
    </span>
</li>

