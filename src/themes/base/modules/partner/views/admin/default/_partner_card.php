<?php
use yii\helpers\Url;

?>
<div class="partner-card">
  <div>
    <label><?= \Yii::t('app/attributes', 'Created At') ?>:</label>
    <?= $model->createdDate ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'User ID') ?>:</label>
    <?= $model->user->nameWithEmail ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Parent Partner ID') ?>:</label>
    <?= $model->parent_partner_id ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Field') ?>:</label>
    <?= $model->field ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'City') ?>:</label>
    <?= $model->city ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Url') ?>:</label>
    <?= $model->url ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Webmoney Rub') ?>:</label>
    <?= $model->webmoney_rub ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Subscribers Count') ?>:</label>
    <?= $model->subscribers_count ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Subscribes Count') ?>:</label>
    <?= $model->subscribes_count ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Sales Count') ?>:</label>
    <?= $model->sales_count ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Sales Sum') ?>:</label>
    <?= $model->sales_sum ?>
  </div>

  <div>
    <label><?= \Yii::t('app/attributes', 'Partner Payments Sum') ?>:</label>
    <?= $model->payments_sum ?>
  </div>
</div>
