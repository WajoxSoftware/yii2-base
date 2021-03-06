<?php
use yii\helpers\Url;

?>
<ul class="collection">
    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Order ID') ?>:</label>
        <span><?= $model->id ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Bill Payment Method') ?>:</label>
        <span><?= $model->bill->paymentMethod ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Created At') ?>:</label>
        <span><?= $model->createdDate ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Sum') ?>:</label>
        <span>
          <?=$model->sumRUR ?>
          <?php if ($model->delivery_sum > 0): ?>
          (+<?= $model->deliverySumRUR ?>)
          <?php endif; ?>
          P
          <br/>

          <?= \Yii::t('app/models', 'Bill') ?> #<?= $model->bill_id ?><br/>
          <?php $bill_url = Url::toRoute(['/payment/admin/bills/view', 'id' => $model->bill_id], true) ?>

          <a href="<?= $bill_url ?>" target="_blank"><?= $bill_url ?></a>

          <br/>

          <?php $bill_payment_url = Url::toRoute(['/payment', 'id' => $model->bill_id], true) ?>
          <a href="<?= $bill_payment_url ?>" target="_blank"><?= $bill_payment_url ?></a>
        </span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Status') ?>:</label>
        <span>
          <?= $model->status ?>
          <?php if ($model->isNew): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'paid', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-success"><?= \Yii::t('app/general', 'Pay') ?></a>

            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'cancelled', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Cancel') ?></a>
          <?php endif; ?>

          <?php if ($model->isPaid): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'returnMoney', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Return') ?></a>
          <?php endif; ?>
        </span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Delivery Status') ?>:</label>
        <span>
          <?= $model->deliveryStatus ?>
          <?php if ($model->isDeliveryWaiting): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'prepared', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-success"><?= \Yii::t('app/general', 'Prepare') ?></a>
          <?php endif; ?>

          <?php if ($model->isPrepared): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'send', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-success"><?= \Yii::t('app/general', 'Send') ?></a>
          <?php endif; ?>

          <?php if ($model->isSend): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'delivered', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-success"><?= \Yii::t('app/general', 'Deliver') ?></a>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'undelivered', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Undeliver') ?></a>
          <?php endif; ?>

          <?php if ($model->isDelivered || $model->isUndelivered): ?>
            <a href="<?= Url::toRoute(['/payment/admin/order-statuses/create', 'status' => 'returned', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Return') ?></a>
          <?php endif; ?>
        </span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Order Saler Comment') ?>:</label>
        <p><?= $model->saler_comment ?></p>
    </li>
</ul>

