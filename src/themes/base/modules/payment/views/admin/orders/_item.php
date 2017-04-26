<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-Order-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['/payment/admin/orders/view', 'id' => $model->id]) ?>">
        Order #<?= $model->id ?>
      </a>
    </span>

    <p>
      <?=$model->sum ?>
      <?php if ($model->delivery_sum > 0): ?>
      (+<?= $model->deliverySumRUR ?>)
      <?php endif; ?>
      P
    </p>
    <p><?=$model->status ?></p>

    <p><?=$model->deliveryStatus ?></p>

    <span class="secondary-content">
    </span>
</li>

