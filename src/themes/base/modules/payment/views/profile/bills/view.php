<?php

use yii\helpers\Url;

$this->title = \Yii::t('app/general', 'View {model}', ['model' => \Yii::t('app/models', 'Bill')]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/profile', 'Nav Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if ($model->isNew) {
    $this->params['pageControls']['items'][] = [
      'title' => \Yii::t('app/general', 'Pay'),
      'url' => ['/payment/default/index', 'id' => $model->id],
      'icon' => 'payment',
    ];
    $this->params['pageControls']['items'][] = [
      'title' => \Yii::t('app/general', 'Cancel'),
      'url' => ['cancel', 'id' => $model->id],
      'icon' => 'cancel',
    ];
}
?>

<div class="row">
    <div class="bill-view col m12">
        <div class="row">
            <div class="col m12">
                <label><?= \Yii::t('app/attributes', 'Created At') ?>:</label>
                <?= $model->createdDate ?>
            </div>
        </div>
        <div class="row">
            <div class="col m12">
                <label><?= \Yii::t('app/attributes', 'Sum') ?>:</label>
                <?= $model->sumRUR ?> P
            </div>
        </div>
        <div class="row">
            <div class="col m12">
                <label><?= \Yii::t('app/attributes', 'Status') ?>:</label>
                <?= $model->status ?>
            </div>
        </div>
        <div class="row">
            <div class="col m12">
                <label><?= \Yii::t('app/attributes', 'Status At') ?>:</label>
                <?= $model->statusDate ?>
            </div>
        </div>

        <div class="row">
            <div class="col m12">
                <label><?= \Yii::t('app/attributes', 'Bill Payment Destination') ?>:</label>
                <?= $model->paymentDestination ?>
            </div>
        </div>

        <?php if ($model->isPaid): ?>
            <div class="row">
                <div class="col m12">
                    <label><?= \Yii::t('app/attributes', 'Bill Payment Method') ?>:</label>
                    <?= $model->paymentMethod ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
