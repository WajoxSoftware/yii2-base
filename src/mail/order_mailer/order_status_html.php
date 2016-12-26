<?php
use yii\helpers\Url;
?>

<h1>Your order #<?= $order->id ?> changed </h1>

<p>
  New order status: <?= $order->status ?> / <?= $order->deliveryStatus ?>.
</p>

<p>
  You can look for updates by link:
  <br/>
  <?php $url = Url::toRoute(['/payment/default/status', 'id' => $order->bill_id], true) ?>
  <a href="<?= $url ?>"><?= $url ?></a>
</p>
